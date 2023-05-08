<?php

namespace App\Repositories\Services;

use App\Models\WithdrawalRequest;
use App\Repositories\Interfaces\WithdrawalRequestInterface;
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
}
