<?php

namespace App\Http\Controllers\Admin;

use App\Models\WithdrawalRequest;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessMail;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AdminWithdrawalRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $withdrawal_request = WithdrawalRequest::query()->with('user', 'withdrawalMethod');
            $withdrawal_request = createdBetween($withdrawal_request, $request);
            $withdrawal_request->orderBy('id', 'desc');
            return $this->datatable($withdrawal_request);
        }

        $auth = Auth::user();
        $datatable_url = '';
        if ($auth->role_id == 1) {
            $datatable_url = route('admin.withdrawal-request.index');
        } else if ($auth->role_id == 2) {
            $datatable_url = route('moderator.withdrawal-request.index');
        }
        return view('content.admin.withdrawal_request.index', ['datatable_url' => $datatable_url]);
    }

    public function approved(Request $request)
    {
        if ($request->ajax()) {
            $withdrawal_request = WithdrawalRequest::query()->with('user', 'withdrawalMethod');
            $withdrawal_request = createdBetween($withdrawal_request, $request);
            $withdrawal_request->status([1])->orderBy('id', 'desc');
            return $this->datatable($withdrawal_request);
        }

        return view('content.admin.withdrawal_request.approved');
    }

    public function cancelled(Request $request)
    {
        if ($request->ajax()) {
            $withdrawal_request = WithdrawalRequest::query()->with('user', 'withdrawalMethod');
            $withdrawal_request = createdBetween($withdrawal_request, $request);
            $withdrawal_request->status([3])->orderBy('id', 'desc');
            return $this->datatable($withdrawal_request);
        }

        return view('content.admin.withdrawal_request.cancelled');
    }

    public function complete(Request $request)
    {
        if ($request->ajax()) {
            $withdrawal_request = WithdrawalRequest::query()->with('user', 'withdrawalMethod');
            $withdrawal_request = createdBetween($withdrawal_request, $request);
            $withdrawal_request->status([2])->orderBy('id', 'desc');
            return $this->datatable($withdrawal_request);
        }

        return view('content.admin.withdrawal_request.complete');
    }

    public function pending(Request $request)
    {
        if ($request->ajax()) {
            $withdrawal_request = WithdrawalRequest::query()->with('user', 'withdrawalMethod');
            $withdrawal_request = createdBetween($withdrawal_request, $request);
            $withdrawal_request->status([0])->orderBy('id', 'desc');
            return $this->datatable($withdrawal_request);
        }
        $auth = Auth::user();
        $datatable_url = '';
        if ($auth->role_id == 1) {
            $datatable_url = route('admin.withdrawal-request.pending');
            $update_url = route('admin.withdrawal-request.update');
        } else if ($auth->role_id == 2) {
            $datatable_url = route('moderator.withdrawal-request.pending');
            $update_url = route('moderator.withdrawal-request.update');
        }
        return view('content.admin.withdrawal_request.pending', ['datatable_url' => $datatable_url, 'update_url' => $update_url]);
    }

    public function returned(Request $request)
    {
        if ($request->ajax()) {
            $withdrawal_request = WithdrawalRequest::query()->with('user', 'withdrawalMethod');
            $withdrawal_request = createdBetween($withdrawal_request, $request);
            $withdrawal_request->status([4])->orderBy('id', 'desc');
            return $this->datatable($withdrawal_request);
        }

        return view('content.admin.withdrawal_request.returned');
    }

    public function update(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'withdraw_request_id' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->respondInvalidRequest($validator->errors());
            }
            $auth = Auth::user();

            DB::beginTransaction();
            $withdrawal_request = WithdrawalRequest::findOrFail($request->withdraw_request_id);
            $current_status = $withdrawal_request->status;
            if ($current_status == 0 && ($request->status == 1 || $request->status == 3 || $request->status == 4)) {

                if ($request->status == 3 || $request->status == 4) {
                    $withdrawal_request->user->wallet->increment('available_balance', $withdrawal_request->request_amount);
                }

                $withdrawal_request->updated_by = $auth->id;
                $withdrawal_request->status = $request->status;
                if ($request->note) {
                    $withdrawal_request->note = $request->note;
                }
                if ($request->transection_id) {
                    $withdrawal_request->transection_id = $request->transection_id;
                }
                $withdrawal_request->save();
            } else if ($current_status == 1 && ($request->status == 2 || $request->status == 3 || $request->status == 4)) {

                if ($request->status == 2) {
                    $withdrawal_request->user->wallet->increment('total_withdraw', $withdrawal_request->request_amount);
                    $withdrawal_request->complete_date = date('Y-m-d H:i:s');
                } else if ($request->status == 3 || $request->status == 4) {
                    $withdrawal_request->user->wallet->increment('available_balance', $withdrawal_request->request_amount);
                }

                $withdrawal_request->updated_by = $auth->id;
                $withdrawal_request->status = $request->status;
                if ($request->note) {
                    $withdrawal_request->note = $request->note;
                }
                if ($request->transection_id) {
                    $withdrawal_request->transection_id = $request->transection_id;
                }
                $withdrawal_request->save();
            }

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

            if ($withdrawal_request->user->email && getAdminSetting('mail_notification') && ($current_status == 0 || $current_status == 1)) {
                $array['view'] = 'content.emails.notification';
                $array['subject'] = "Withdraw Request";
                $array['name'] = $withdrawal_request->user->name ?? $withdrawal_request->user->username;
                $array['to'] = $withdrawal_request->user->email;
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

            return $this->respondCreated('Withdrawal request updated successfully!', $withdrawal_request);
        } catch (\Exception $ex) {
            DB::rollBack();
            return $this->respondInternalError($ex->getMessage());
        }
    }

    private function datatable($withdrawal_request)
    {
        return DataTables::of($withdrawal_request)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $action = '<div class="btn-group" role="group" aria-label="Basic example">
                <a href="javascript:;" class="btn btn-primary btn-sm" onclick="changeStatus(' . $row->id . ')"><i class="fas fa-edit"></i></a>
                </div>';
                return $action;
            })
            ->addColumn('payment_method', function ($row) {
                return $row->withdrawalMethod->paymentMethod->name;
            })
            ->addColumn('withdrawal_account', function ($row) {
                return $row->withdrawalMethod->withdrawal_account;
            })
            ->addColumn('user', function ($row) {
                return $row->user->name ?? $row->user->username;
            })
            ->editColumn('status', function ($row) {
                $status = '<span class="status-badge badge badge-warning">Pending</span>';
                if ($row->status == 1) {
                    $status = '<span class="status-badge badge badge-info">Approved</span>';
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
            ->editColumn('complete_date', function ($row) {
                if ($row->complete_date) {
                    return date('d M Y h:ia', strtotime($row->complete_date));
                }
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }
}
