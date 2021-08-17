<?php

declare(strict_types=1);

namespace App\AdminCache;

use App\AdminCore\AdminCoreModule;
use App\AdminModuleInterface;
use App\ModuleTrait;

final class AdminCacheModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_cache';
    public const ENABLE = AdminCoreModule::ENABLE && true;
    public const LOCALIZE = false;
}
