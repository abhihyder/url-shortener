<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\ReferralEarning;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ReferralController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $referred_users = User::query()->where(['referrer_id' => Auth::user()->id]);
            $referred_users = createdBetween($referred_users, $request);
            $referred_users->select('created_at', 'username', 'earning_disable')->orderBy('id', 'desc');

            return DataTables::of($referred_users)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return date('d M Y h:ia', strtotime($row->created_at));
                })
                ->editColumn('earning_disable', function ($row) {
                    $earning_disable = '<span class="status-badge badge badge-success">No</span>';
                    if ($row->earning_disable == 1) {
                        $earning_disable = '<span class="status-badge badge badge-danger">Yes</span>';
                    }
                    return $earning_disable;
                })
                ->rawColumns(['earning_disable'])
                ->make(true);
        }

        $banners = Banner::where(['user_id' => Auth::user()->id])->orderBy('name', 'asc')->get();
        return view('content.referral.index', ['banners' => $banners]);
    }

    public function earning(Request $request)
    {
        if ($request->ajax()) {
            $referral_earnings = ReferralEarning::query()->with('referred')->where(['referrer_id' => Auth::user()->id]);
            $referral_earnings = createdBetween($referral_earnings, $request);
            $referral_earnings->orderBy('id', 'desc');

            return DataTables::of($referral_earnings)
                ->addIndexColumn()
                ->addColumn('referred_user', function ($row) {
                    return $row->referred->username;
                })
                ->editColumn('created_at', function ($row) {
                    return date('d M Y h:ia', strtotime($row->created_at));
                })
                ->make(true);
        }

        return view('content.referral.earning');
    }
}
