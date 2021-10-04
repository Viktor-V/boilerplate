<?php

declare(strict_types=1);

namespace App\Admin\AdminSecurity;

use App\Core\Module\Contract\AdminModuleInterface;
use App\Core\Module\ModuleTrait;

final class AdminSecurityModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_security';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
