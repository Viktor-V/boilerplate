<?php

declare(strict_types=1);

namespace App\AdminLanguage;

use App\AdminModuleInterface;
use App\AdminModuleTrait;
use App\Common\Language\LanguageModule;

final class AdminLanguageModule implements AdminModuleInterface
{
    use AdminModuleTrait;

    public const NAME = 'admin_language';
    public const ENABLE = true;
    public const LOCALIZE = false;

    public function enable(): bool
    {
        return LanguageModule::ENABLE && self::ENABLE;
    }
}
