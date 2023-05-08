<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class WithdrawalRequestFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'withdrawal-request-facade-service';
    }
}
