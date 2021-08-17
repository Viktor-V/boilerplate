<?php

declare(strict_types=1);

namespace App\AdminDashboard;

use App\AdminModuleInterface;
use App\AdminModuleTrait;

final class AdminDashboardModule implements AdminModuleInterface
{
    use AdminModuleTrait;

    public const NAME = 'admin_dashboard';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
