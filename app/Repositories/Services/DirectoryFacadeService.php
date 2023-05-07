<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\DirectoryInterface;

class DirectoryFacadeService implements DirectoryInterface
{
    public function make(string $path)
    {
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }
    }
}
