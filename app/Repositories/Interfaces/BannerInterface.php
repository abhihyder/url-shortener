<?php

namespace App\Repositories\Interfaces;

interface BannerInterface
{
    public function datatables();

    public function store(array $request);
}
