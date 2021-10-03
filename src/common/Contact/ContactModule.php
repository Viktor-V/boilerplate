<?php

declare(strict_types=1);

namespace App\Common\Contact;

use App\Core\Module\Contract\ModuleInterface;
use App\Core\Module\ModuleTrait;

final class ContactModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'contact';
    public const ENABLE = true;
    public const LOCALIZE = true;
}
