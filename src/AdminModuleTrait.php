<?php

declare(strict_types=1);

namespace App;

use App\AdminCore\AdminCoreModule;

trait AdminModuleTrait
{
    use ModuleTrait;

    public function enable(): bool
    {
        return AdminCoreModule::ENABLE && self::ENABLE;
    }
}
