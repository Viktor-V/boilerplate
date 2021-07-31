<?php

declare(strict_types=1);

namespace App\Core;

use App\ModuleInterface;

final class CoreModule implements ModuleInterface
{
    public const NAME = 'core';
    public const ENABLE = true;
    public const LOCALIZE = false;

    public function name(): string
    {
        return self::NAME;
    }

    public function enable(): bool
    {
        return self::ENABLE;
    }

    public function localize(): bool
    {
        return self::LOCALIZE;
    }
}
