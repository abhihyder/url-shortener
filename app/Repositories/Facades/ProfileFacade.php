<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class ProfileFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'profile-facade-service';
    }
}
