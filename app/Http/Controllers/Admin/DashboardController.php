<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Facades\StatisticsFacade;
use Illuminate\Http\Request;

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
        return StatisticsFacade::chartData($request->all());
    }

    public function getStatistics(Request $request)
    {
        return StatisticsFacade::statistics($request->all());
    }
}
