<?php

declare(strict_types=1);

namespace App\AdminCache;

use App\AdminModuleInterface;
use App\AdminModuleTrait;

final class AdminCacheModule implements AdminModuleInterface
{
    use AdminModuleTrait;

    public const NAME = 'admin_cache';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
