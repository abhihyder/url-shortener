<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class BannerFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'banner-facade-service';
    }
}
