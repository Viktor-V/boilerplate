<?php

declare(strict_types=1);

namespace App\Common\Language;

use App\ModuleInterface;
use App\ModuleTrait;

final class LanguageModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'language';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
