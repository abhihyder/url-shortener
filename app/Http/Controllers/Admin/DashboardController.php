<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralEarning;
use App\Models\Visitor;
use App\Models\WithdrawalRequest;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('content.admin.dashboard');
    }

    public function userIndex()
    {
        return view('content.dashboard.dashboard');
    }

    public function getData(Request $request)
    {

        $visitors = Visitor::when($request->user, function ($query) {
            $query->myVisitor();
        })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])
            ->select(
                DB::raw("(count(id)) as total_visitor"),
                DB::raw("(sum(is_unique)) as total_unique"),
                DB::raw("(sum(payment)) as total_payment"),
            )
            ->get();

        $referral_earnings = ReferralEarning::when($request->user, function ($query) {
            $query->myReferrer();
        })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])->sum('amount');

        $processing = WithdrawalRequest::when($request->user, function ($query) {
            $query->myRequest();
        })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])->status([0, 1])->sum('request_amount');
        $complete = WithdrawalRequest::when($request->user, function ($query) {
            $query->myRequest();
        })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])->status([2])->sum('request_amount');
        $process_failed = WithdrawalRequest::when($request->user, function ($query) {
            $query->myRequest();
        })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])->status([3, 4])->sum('request_amount');

        $data = [
            'visitors' => $visitors,
            'processing' => $processing,
            'complete' => $complete,
            'process_failed' => $process_failed,
            'referral_earnings' => $referral_earnings,
        ];
        return $this->respondWithData($data);
    }

    public function getStatistics(Request $request)
    {

        $days = [];
        $period = new DatePeriod(
            new DateTime(date('Y-m-1')),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime('+1 day')))
        );

        foreach ($period as $value) {
            $days[] = $value->format('d M Y');
        }

        $visitors = Visitor::when($request->user, function ($query) {
            $query->myVisitor();
        })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])
            ->select(
                DB::raw("(date(`created_at`)) as created_date"),
                DB::raw("(count(id)) as total_visitor"),
                DB::raw("(sum(is_unique)) as total_unique"),
                DB::raw("(sum(payment)) as total_payment"),
            )
            ->groupBy(DB::raw("date(`created_at`)"))
            ->get();

        if ($visitors) {
            foreach ($visitors as $visitor) {
                $visitor->created_date = date('d M Y', strtotime($visitor->created_date));
            }
        }

        $data = [
            'days' => $days,
            'visitors' => $visitors,
        ];
        return $this->respondWithData($data);
    }
}
