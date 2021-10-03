<?php

declare(strict_types=1);

namespace App\Common\Home;

use App\ModuleInterface;
use App\ModuleTrait;

final class HomeModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'home';
    public const ENABLE = true;
    public const LOCALIZE = true;
}
