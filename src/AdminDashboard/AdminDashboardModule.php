<?php

declare(strict_types=1);

namespace App\AdminDashboard;

use App\ModuleInterface;

final class AdminDashboardModule implements ModuleInterface
{
    public const NAME = 'admin_dashboard';
    public const ENABLE = true;
    public const LOCALIZE = false;

    public function name(): string
    {
        return self::NAME;
    }

    public function enable(): bool
    {
        return self::ENABLE;
    }

    public function localize(): bool
    {
        return self::LOCALIZE;
    }
}
