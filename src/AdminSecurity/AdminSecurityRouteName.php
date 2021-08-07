<?php

declare(strict_types=1);

namespace App\AdminSecurity;

use App\AdminCore\AdminCoreRouteName;

class AdminSecurityRouteName
{
    public const AUTH = AdminCoreRouteName::ADMIN_CORE_NAME . 'auth';
    public const AUTH_PATH = 'auth';
}
