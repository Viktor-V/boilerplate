<?php

declare(strict_types=1);

namespace App\Common\AntiSpam;

use App\ModuleInterface;
use App\ModuleTrait;

final class AntiSpamModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'anti_spam';
    public const ENABLE = true;
    public const LOCALIZE = false;
}
