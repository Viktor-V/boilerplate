<?php

declare(strict_types=1);

namespace App\AdminLanguage;

use App\AdminCore\AdminCoreModule;
use App\AdminModuleInterface;
use App\AdminModuleTrait;
use App\Language\LanguageModule;

final class AdminLanguageModule implements AdminModuleInterface
{
    use AdminModuleTrait;

    public const NAME = 'admin_language';
    public const ENABLE = true;
    public const LOCALIZE = false;

    public function enable(): bool
    {
        return AdminCoreModule::ENABLE && LanguageModule::ENABLE && self::ENABLE;
    }
}
