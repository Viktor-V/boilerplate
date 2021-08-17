<?php

declare(strict_types=1);

namespace App\AdminDashboard;

use App\AdminCore\AdminCoreModule;
use App\AdminModuleInterface;
use App\ModuleTrait;

final class AdminDashboardModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_dashboard';
    public const ENABLE = AdminCoreModule::ENABLE && true;
    public const LOCALIZE = false;
}
