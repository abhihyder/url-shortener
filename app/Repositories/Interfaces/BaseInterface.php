<?php

namespace App\Repositories\Interfaces;

interface BaseInterface
{
    public function index();

    public function store(array $request);

    public function find(int $id);

    public function update(array $request);

    public function destroy(int $id);
}
