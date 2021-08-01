<?php

declare(strict_types=1);

namespace App\AdminCore;

use App\AdminModuleInterface;

final class AdminCoreModule implements AdminModuleInterface
{
    public const NAME = 'admin_core';
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
