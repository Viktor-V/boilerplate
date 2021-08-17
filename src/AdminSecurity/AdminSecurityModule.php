<?php

declare(strict_types=1);

namespace App\AdminSecurity;

use App\AdminModuleInterface;
use App\AdminModuleTrait;

final class AdminSecurityModule implements AdminModuleInterface
{
    use AdminModuleTrait;

    public const NAME = 'admin_security';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
