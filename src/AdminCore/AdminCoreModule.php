<?php

declare(strict_types=1);

namespace App\AdminCore;

use App\AdminModuleInterface;
use App\ModuleTrait;

final class AdminCoreModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_core';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
