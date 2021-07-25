<?php

declare(strict_types=1);

namespace App\Admin;

use App\ModuleInterface;

final class AdminModule implements ModuleInterface
{
    public const NAME = 'admin';
    public const ENABLED = true;

    public function name(): string
    {
        return self::NAME;
    }

    public function enabled(): bool
    {
        return self::ENABLED;
    }
}
