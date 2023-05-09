<?php

namespace App\Repositories\Interfaces;

interface PaymentMethodInterface
{
    public function datatables();

    public function store(array $request);

    public function find(int $id);

    public function update(array $request, int $id);
}
