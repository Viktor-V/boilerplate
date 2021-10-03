<?php

declare(strict_types=1);

namespace App\Common\Language;

use App\Core\Module\Contract\ModuleInterface;
use App\Core\Module\ModuleTrait;

final class LanguageModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'language';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
