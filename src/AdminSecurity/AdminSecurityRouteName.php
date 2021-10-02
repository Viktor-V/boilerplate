<?php

declare(strict_types=1);

namespace App\AdminSecurity;

use App\AdminCore\Infrastructure\Controller\AbstractController;

class AdminSecurityRouteName
{
    public const AUTH = AbstractController::ADMIN_CORE_NAME . 'auth';
    public const AUTH_PATH = 'auth';

    public const LOGOUT = self::AUTH . '_logout';
    public const LOGOUT_PATH = 'logout';
}
