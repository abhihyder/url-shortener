<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        return view('content.statistics.index');
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

        $visitors = Visitor::myVisitor()
            ->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])
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

        $wallet = Wallet::myWallet()->first();
        $processing_request = WithdrawalRequest::myRequest()->status([0, 1])->sum('request_amount');
        $data = [
            'days' => $days,
            'visitors' => $visitors,
            'wallet' => $wallet,
            'processing_request' => $processing_request
        ];
        return $this->respondWithData($data);
    }
}
