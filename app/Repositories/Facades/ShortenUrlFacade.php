<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class ShortenUrlFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'shorten-url-facade-service';
    }
}
