<?php

namespace App\Repositories\Services;

use App\Jobs\ProcessMail;
use App\Mail\NotificationMail;
use App\Models\WithdrawalRequest;
use App\Repositories\Interfaces\WithdrawalRequestInterface;
use Hyder\JsonResponse\Facades\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class WithdrawalRequestFacadeService implements WithdrawalRequestInterface
{
    public function index(array $request, array $status = [])
    {
        $withdrawal_request = WithdrawalRequest::with('user', 'withdrawalMethod')
            ->when((isset($request['date_range']) && $request['date_range']), function ($query) use ($request) {
                $date = explode(' ', $request['date_range']);
                if (count($date) == 1) {
                    $query->whereBetween('created_at', [$date[0] . date(' 00:00:00'), $date[0] . date(' 23:59:59')]);
                } else {
                    $query->whereBetween('created_at', [$date[0] . date(' 00:00:00'), $date[2] . date(' 23:59:59')]);
                }
            })
            ->when($status, function ($query) use ($status) {
                $query->status($status);
            })
            ->orderBy('id', 'desc');
        return $this->datatable($withdrawal_request);
    }

    public function update(array $request)
    {
        try {

            $validator = $this->validation($request);

            if ($validator->fails()) {
                return JsonResponse::invalidRequest($validator->errors());
            }

            DB::beginTransaction();
            $withdrawal_request = WithdrawalRequest::findOrFail($request['withdraw_request_id']);
            $current_status = $withdrawal_request->status;

            $this->updateWithdrawalAndWallet($withdrawal_request, $request, $current_status);

            DB::commit();

            $this->updateCache();

            $this->notifiyUser($withdrawal_request, $current_status);

            return JsonResponse::success('Withdrawal request updated successfully!', $withdrawal_request);
        } catch (\Exception $ex) {
            DB::rollBack();
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    public function sum(array $request, array $status, bool $between = false): int
    {
        return WithdrawalRequest::when((isset($request['user']) && $request['user']), function ($query) {
            $query->myRequest();
        })
            ->when($between, function ($query) {
                $query->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')]);
            })
            ->status($status)->sum('request_amount');
    }

    public function count(array $status)
    {
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

    private function updateWithdrawalAndWallet($withdrawal_request, $request, $current_status)
    {
        $auth = Auth::user();

        if ($current_status == 0 && ($request['status'] == 1 || $request['status'] == 3 || $request['status'] == 4)) {

            if ($request['status'] == 3 || $request['status'] == 4) {
                $withdrawal_request->user->wallet->increment('available_balance', $withdrawal_request->request_amount);
            }

            $withdrawal_request->updated_by = $auth->id;
            $withdrawal_request->status = $request['status'];
            if ($request['note']) {
                $withdrawal_request->note = $request['note'];
            }
            if (isset($request['transection_id']) && $request['transection_id']) {
                $withdrawal_request->transection_id = $request['transection_id'];
            }
            $withdrawal_request->save();
        } else if ($current_status == 1 && ($request['status'] == 2 || $request['status'] == 3 || $request['status'] == 4)) {

            if ($request['status'] == 2) {
                $withdrawal_request->user->wallet->increment('total_withdraw', $withdrawal_request->request_amount);
                $withdrawal_request->complete_date = date('Y-m-d H:i:s');
            } else if ($request['status'] == 3 || $request['status'] == 4) {
                $withdrawal_request->user->wallet->increment('available_balance', $withdrawal_request->request_amount);
            }

            $withdrawal_request->updated_by = $auth->id;
            $withdrawal_request->status = $request['status'];
            if ($request['note']) {
                $withdrawal_request->note = $request['note'];
            }
            if (isset($request['transection_id']) && $request['transection_id']) {
                $withdrawal_request->transection_id = $request['transection_id'];
            }
            $withdrawal_request->save();
        }

        return true;
    }

    private function updateCache()
    {
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

        return true;
    }

    private function notifiyUser($withdrawal_request, $current_status)
    {
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

        return true;
    }

    private function validation(array $request)
    {
        return Validator::make($request, [
            'withdraw_request_id' => 'required',
            'status' => 'required',
        ]);
    }
}
