<?php

declare(strict_types=1);

namespace App\Admin\AdminLanguage;

use App\Core\Module\Contract\AdminModuleInterface;
use App\Core\Module\ModuleTrait;
use App\Common\Language\LanguageModule;

final class AdminLanguageModule implements AdminModuleInterface
{
    use ModuleTrait;

    public const NAME = 'admin_language';
    public const ENABLE = true;
    public const LOCALIZE = false;

    public function enable(): bool
    {
        return LanguageModule::ENABLE && self::ENABLE;
    }
}
