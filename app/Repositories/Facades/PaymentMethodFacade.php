<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class PaymentMethodFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'payment-method-facade-service';
    }
}
