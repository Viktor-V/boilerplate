<?php

declare(strict_types=1);

namespace App\AdminCache;

use App\Core\Module\Contract\AdminModuleInterface;
use App\Core\Module\ModuleTrait;

final class AdminCacheModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_cache';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
