<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class StatisticsFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'statistics-facade-service';
    }
}
