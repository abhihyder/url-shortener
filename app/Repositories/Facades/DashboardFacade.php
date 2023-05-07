<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardFacade extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'dashboard-facade-service';
    }
}
