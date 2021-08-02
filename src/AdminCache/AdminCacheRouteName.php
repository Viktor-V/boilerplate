<?php

declare(strict_types=1);

namespace App\AdminCache;

use App\AdminCore\AdminCoreRouteName;

final class AdminCacheRouteName
{
    public const CACHE = AdminCoreRouteName::ADMIN_CORE_NAME . 'cache';
    public const CACHE_PATH = 'cache';

    public const CACHE_CLEAR = self::CACHE . '_clear';
    public const CACHE_CLEAR_PATH = self::CACHE_PATH . '/clear';

    public const CACHE_WARM = self::CACHE . '_warm';
    public const CACHE_WARM_PATH = self::CACHE_PATH . '/warm';
}
