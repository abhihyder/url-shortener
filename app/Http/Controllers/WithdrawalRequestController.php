<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessMail;
use App\Mail\NotificationMail;
use App\Models\PaymentMethod;
use App\Models\Wallet;
use App\Models\WithdrawalMethod;
use App\Models\WithdrawalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class WithdrawalRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return DataTables::of(WithdrawalRequest::query()->with('withdrawalMethod')->myRequest()->orderBy('id', 'desc'))
                ->addIndexColumn()
                ->addColumn('payment_method', function ($row) {
                    return $row->withdrawalMethod->paymentMethod->name;
                })
                ->addColumn('withdrawal_account', function ($row) {
                    return $row->withdrawalMethod->withdrawal_account;
                })
                ->editColumn('status', function ($row) {
                    $status = '<span class="badge badge-warning">Pending</span>';
                    if ($row->status == 1) {
                        $status = '<span class="badge badge-info">Approved</span>';
                    } else if ($row->status == 2) {
                        $status = '<span class="badge badge-success">Complete</span>';
                    } else if ($row->status == 3) {
                        $status = '<span class="badge badge-danger">Cancelled</span>';
                    } else if ($row->status == 4) {
                        $status = '<span class="badge badge-primary">Rerurned</span>';
                    }
                    return $status;
                })
                ->editColumn('request_amount', function ($row) {

                    return "$" . number_format($row->request_amount, 4);
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y h:ia', strtotime($row->created_at));
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        $wallet = Wallet::myWallet()->first();
        $withdrawal_methods = WithdrawalMethod::myMethod()->get()->groupBy('payment_method_id');
        $processing_request = WithdrawalRequest::myRequest()->status([0, 1])->sum('request_amount');

        return view('content.withdrawal.request.index', ['wallet' => $wallet, 'withdrawal_methods' => $withdrawal_methods, 'processing_request' => $processing_request]);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payment_method' => 'required',
                'withdrawal_method' => 'required',
                'withdraw_amount' => 'required|numeric|min:0',
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }
            $auth = Auth::user();

            $withdrawal_method = WithdrawalMethod::with('paymentMethod')->findOrFail($request->withdrawal_method);

            if ($auth->wallet->available_balance < $withdrawal_method->paymentMethod->min_withdrawal_amount) {
                return $this->respondBadRequest("You don't have sufficient balance! Minimum amount $" . $withdrawal_method->paymentMethod->min_withdrawal_amount . ".");
            } else if ($request->withdraw_amount > $auth->wallet->available_balance) {
                return $this->respondBadRequest("You can't withdraw more then $" . $auth->wallet->available_balance . ".");
            } else if ($request->withdraw_amount < $withdrawal_method->paymentMethod->min_withdrawal_amount) {
                return $this->respondBadRequest("You can't withdraw less then $" . $withdrawal_method->paymentMethod->min_withdrawal_amount . ".");
            }

            DB::beginTransaction();
            $withdrawal_request = new WithdrawalRequest();
            $withdrawal_request->user_id = $auth->id;
            $withdrawal_request->withdrawal_method_id = $request->withdrawal_method;
            $withdrawal_request->request_amount = $request->withdraw_amount;
            $withdrawal_request->remaining_balance = ($auth->wallet->available_balance - $request->withdraw_amount);
            $withdrawal_request->save();
            $auth->wallet->decrement('available_balance', $request->withdraw_amount);
            DB::commit();

            $pending_request = WithdrawalRequest::status([0])->count();
            $approved_request = WithdrawalRequest::status([1])->count();

            $pending_by_user = WithdrawalRequest::status([0])
                ->select(
                    'user_id',
                    DB::raw("(count(id)) as total_pending"),
                )
                ->groupBy('user_id')
                ->get();
            $approved_by_user = WithdrawalRequest::status([1])
                ->select(
                    'user_id',
                    DB::raw("(count(id)) as total_approved"),
                )
                ->groupBy('user_id')
                ->get();

            $pending_request_by_user = [];
            $approved_request_by_user = [];
            foreach ($pending_by_user as $pending) {
                $pending_request_by_user[$pending->user_id] = $pending->total_pending;
            }

            foreach ($approved_by_user as $approved) {
                $approved_request_by_user[$approved->user_id] = $approved->total_approved;
            }

            $data = [
                'pending_request' => $pending_request,
                'pending_request_by_user' => $pending_request_by_user,
                'approved_request' => $approved_request,
                'approved_request_by_user' => $approved_request_by_user,
            ];
            Cache::put('withdrawal_request', $data);

            if ($auth->email && getAdminSetting('mail_notification')) {
                $array['view'] = 'content.emails.notification';
                $array['subject'] = "Withdraw Request";
                $array['name'] = $auth->name ?? $auth->username;
                $array['to'] = $auth->email;
                $array['withdrawal_request'] = $withdrawal_request;
                $array['timezone'] = config('app.timezone');
                $array['content'] = "";

                if (getAdminSetting('queue_work')) {
                    ProcessMail::dispatch($array)
                        ->delay(now()->addSeconds(5));
                } else {
                    Config::set('queue.default', 'sync');
                    Mail::to($array['to'])->queue(new NotificationMail($array));
                }
            }

            return $this->respondCreated('Withdrawal request created successfully!', $withdrawal_request);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }
}
