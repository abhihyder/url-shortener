<?php

namespace App\Repositories\Services;

use App\Models\ReferralEarning;
use App\Models\Visitor;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use App\Repositories\Facades\WithdrawalRequestFacade;
use App\Repositories\Interfaces\StatisticsInterface;
use DateInterval;
use DatePeriod;
use DateTime;
use Hyder\JsonResponse\Facades\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsFacadeService implements StatisticsInterface
{
    public function statistics(array $request)
    {
        try {

            $visitors = $this->visitorQuery($request)->select(
                DB::raw("(date(`created_at`)) as created_date"),
                DB::raw("(count(id)) as total_visitor"),
                DB::raw("(sum(is_unique)) as total_unique"),
                DB::raw("(sum(payment)) as total_payment"),
            )
                ->groupBy(DB::raw("date(`created_at`)"))
                ->get();

            if ($visitors) {
                foreach ($visitors as $visitor) $visitor->created_date = date('d M Y', strtotime($visitor->created_date));
            }

            $data = [
                'days' => $this->days(),
                'visitors' => $visitors
            ];

            if (isset($request['summary']) && $request['summary']) $data = array_merge($data, $this->summary());

            return JsonResponse::withData($data);
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    public function chartData(array $request)
    {
        try {

            $data['visitors'] =  $this->visitorQuery($request)->select(
                DB::raw("(count(id)) as total_visitor"),
                DB::raw("(sum(is_unique)) as total_unique"),
                DB::raw("(sum(payment)) as total_payment"),
            )
                ->get();

            $data['referral_earnings'] = ReferralEarning::when((isset($request['user']) && $request['user']), function ($query) {
                $query->myReferrer();
            })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')])->sum('amount');

            $data['processing'] = WithdrawalRequestFacade::sum($request, [1, 2], true);

            $data['complete'] = WithdrawalRequestFacade::sum($request, [2], true);

            $data['process_failed'] = WithdrawalRequestFacade::sum($request, [3, 4], true);

            return JsonResponse::withData($data);
        } catch (\Exception $ex) {
            return JsonResponse::internalError($ex->getMessage());
        }
    }

    private function visitorQuery(array $request)
    {
        return Visitor::when((isset($request['user']) && $request['user']), function ($query) {
            $query->myVisitor();
        })->whereBetween('created_at', [date('Y-m-1 00:00:00'), date('Y-m-d 23:59:59')]);
    }

    private function summary(): array
    {
        $summary = [
            'wallet' => Wallet::myWallet()->first(),
            'processing_request' => WithdrawalRequestFacade::sum(['user' => true], [1, 2])
        ];

        return $summary;
    }

    private function days(): array
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

        return $days;
    }
}
