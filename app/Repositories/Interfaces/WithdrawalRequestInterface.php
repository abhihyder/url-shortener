<?php

namespace App\Repositories\Interfaces;

interface WithdrawalRequestInterface
{
    public function index(array $request, array $status = []);

    public function sum(array $request, array $status, bool $between = false);

    public function count(array $status);
}
