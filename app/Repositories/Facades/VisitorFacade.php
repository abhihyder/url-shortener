<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class VisitorFacade extends Facade
{

    public static function getFacadeAccessor()
    {
        return 'visitor-facade-service';
    }
}
