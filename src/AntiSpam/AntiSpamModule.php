<?php

declare(strict_types=1);

namespace App\AntiSpam;

use App\ModuleInterface;

final class AntiSpamModule implements ModuleInterface
{
    public const NAME = 'anti_spam';
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
