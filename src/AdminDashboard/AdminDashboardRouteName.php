<?php

declare(strict_types=1);

namespace App\AdminDashboard;

use App\AdminCore\Infrastructure\Controller\AbstractController;

final class AdminDashboardRouteName
{
    public const DASHBOARD = AbstractController::ADMIN_CORE_NAME . 'dashboard';
    public const DASHBOARD_PATH = null;
}
