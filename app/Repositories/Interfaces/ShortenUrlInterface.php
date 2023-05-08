<?php

namespace App\Repositories\Interfaces;

interface ShortenUrlInterface
{
    public function datatables();

    public function store(array $request);

    public function find(int $id);

    public function update(array $request);
    
}
