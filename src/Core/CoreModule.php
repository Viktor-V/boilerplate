<?php

declare(strict_types=1);

namespace App\Core;

use App\ModuleInterface;

class CoreModule implements ModuleInterface
{
    private const MODULE_NAME = 'core';

    public function name(): string
    {
        return self::MODULE_NAME;
    }

    public function enabled(): bool
    {
        return true;
    }
}
