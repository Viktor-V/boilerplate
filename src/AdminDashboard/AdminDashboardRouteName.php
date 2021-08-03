<?php

declare(strict_types=1);

namespace App\AdminDashboard;

use App\AdminCore\AdminCoreRouteName;

final class AdminDashboardRouteName
{
    public const DASHBOARD = AdminCoreRouteName::ADMIN_CORE_NAME . 'dashboard';
    public const DASHBOARD_PATH = null;

    public const AUTH = AdminCoreRouteName::ADMIN_CORE_NAME . 'auth';
    public const AUTH_PATH = 'auth';
}