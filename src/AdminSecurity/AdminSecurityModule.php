<?php

declare(strict_types=1);

namespace App\AdminSecurity;

use App\AdminCore\AdminCoreModule;
use App\AdminModuleInterface;
use App\ModuleTrait;

class AdminSecurityModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_security';
    public const ENABLE = AdminCoreModule::ENABLE && true;
    public const LOCALIZE = false;
}
