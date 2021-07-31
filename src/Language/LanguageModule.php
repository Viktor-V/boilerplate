<?php

declare(strict_types=1);

namespace App\Language;

use App\ModuleInterface;

final class LanguageModule implements ModuleInterface
{
    public const NAME = 'language';
    public const ENABLE = true;
    public const LOCALIZE = false;

    public function name(): string
    {
        return self::NAME;
    }

    public function enable(): bool
    {
        return self::ENABLE;
    }

    public function localize(): bool
    {
        return self::LOCALIZE;
    }
}
