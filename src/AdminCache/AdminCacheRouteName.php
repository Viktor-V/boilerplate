<?php

declare(strict_types=1);

namespace App\AdminCache;

final class AdminCacheRouteName
{
    public const ADMIN = 'admin';
    public const ADMIN_PATH = self::ADMIN;

    public const AUTH = 'auth';
    public const AUTH_PATH = self::ADMIN_PATH . '/' . self::AUTH;
}
