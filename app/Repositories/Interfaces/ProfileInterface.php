<?php

namespace App\Repositories\Interfaces;

interface ProfileInterface
{
    public function changeInfo(array $request);

    public function changePassword(array $request);
    
    public function changeTheme(array $request);
}
