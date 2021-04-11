<?php

declare(strict_types=1);

namespace App\Core;

use App\ModuleInterface;

final class CoreModule implements ModuleInterface
{
    public const NAME = 'core';
    public const ENABLED = true;
}
