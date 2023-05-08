<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Wallet;
use App\Models\WithdrawalRequest;
use App\Repositories\Facades\StatisticsFacade;
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
        return StatisticsFacade::statistics($request->all());
    }
}
