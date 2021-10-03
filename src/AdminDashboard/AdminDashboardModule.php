<?php

declare(strict_types=1);

namespace App\AdminDashboard;

use App\Core\Module\Contract\AdminModuleInterface;
use App\Core\Module\ModuleTrait;

final class AdminDashboardModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_dashboard';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
