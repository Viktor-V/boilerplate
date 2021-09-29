<?php

declare(strict_types=1);

namespace App\Core;

use App\ModuleInterface;
use App\ModuleTrait;

final class CoreModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'core';
    public const ENABLE = true;
    public const LOCALIZE = true;
}
