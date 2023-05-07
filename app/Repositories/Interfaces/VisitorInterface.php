<?php

namespace App\Repositories\Interfaces;

interface VisitorInterface
{
    public function visit(string $urlCode);

    public function accessCode(array $request);

    public function datatables();
}
