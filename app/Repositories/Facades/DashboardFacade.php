<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class DashboardFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'dashboard-facade-service';
    }
}
