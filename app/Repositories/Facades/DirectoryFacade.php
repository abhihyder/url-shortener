<?php

namespace App\Repositories\Facades;

use Illuminate\Support\Facades\Facade;

class DirectoryFacade extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'directory-facade-service';
    }
}
