<?php

namespace App\Repositories\Interfaces;

interface StatisticsInterface
{
    public function statistics(array $request);

    public function chartData(array $request);
}
