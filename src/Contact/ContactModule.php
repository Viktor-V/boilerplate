<?php

declare(strict_types=1);

namespace App\Contact;

use App\ModuleInterface;

final class ContactModule implements ModuleInterface
{
    public const NAME = 'contact';
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
