<?php

declare(strict_types=1);

namespace App\Contact;

use App\ModuleInterface;

final class ContactModule implements ModuleInterface
{
    public const NAME = 'contact';
    public const ENABLE = true;
    public const LOCALIZE = true;

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
