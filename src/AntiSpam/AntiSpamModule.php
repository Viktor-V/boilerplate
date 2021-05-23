<?php

declare(strict_types=1);

namespace App\AntiSpam;

use App\ModuleInterface;

final class AntiSpamModule implements ModuleInterface
{
    public const NAME = 'anti_spam';
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
