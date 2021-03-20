<?php

declare(strict_types=1);

namespace App\Core\Adapter\Service;

use App\Kernel;

class ProjectInfo
{
    /**
     * @return array<string, string>
     */
    public function info(): array
    {
        return ['php' => PHP_VERSION, 'symfony' => Kernel::VERSION, 'env' => $_SERVER['APP_ENV']];
    }
}
