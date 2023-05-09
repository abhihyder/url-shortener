<?php

namespace App\Http\Controllers\Admin;

use App\Models\WithdrawalRequest;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessMail;
use App\Mail\NotificationMail;
use App\Repositories\Facades\WithdrawalRequestFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AdminWithdrawalRequestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return WithdrawalRequestFacade::index($request->all());
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
            return WithdrawalRequestFacade::index($request->all(), [1]);
        }

        return view('content.admin.withdrawal_request.approved');
    }

    public function cancelled(Request $request)
    {
        if ($request->ajax()) {
            return WithdrawalRequestFacade::index($request->all(), [3]);
        }

        return view('content.admin.withdrawal_request.cancelled');
    }

    public function complete(Request $request)
    {
        if ($request->ajax()) {
            return WithdrawalRequestFacade::index($request->all(), [2]);
        }

        return view('content.admin.withdrawal_request.complete');
    }

    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return WithdrawalRequestFacade::index($request->all(), [0]);
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
            return WithdrawalRequestFacade::index($request->all(), [4]);
        }

        return view('content.admin.withdrawal_request.returned');
    }

    public function update(Request $request)
    {
        return WithdrawalRequestFacade::update($request->all());
    }
}
