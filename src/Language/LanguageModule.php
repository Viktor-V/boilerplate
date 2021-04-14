<?php

declare(strict_types=1);

namespace App\Language;

use App\ModuleInterface;

class LanguageModule implements ModuleInterface
{
    public const NAME = 'language';
    public const ENABLED = true;

    public function name(): string
    {
        return self::NAME;
    }

    public function enabled(): bool
    {
        return self::ENABLED;
    }
}
