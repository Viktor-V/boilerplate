<?php

declare(strict_types=1);

namespace App\Common\Contact;

use App\ModuleInterface;
use App\ModuleTrait;

final class ContactModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'contact';
    public const ENABLE = true;
    public const LOCALIZE = true;
}
