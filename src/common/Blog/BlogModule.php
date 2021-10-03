<?php

declare(strict_types=1);

namespace App\Common\Blog;

use App\Core\Module\Contract\ModuleInterface;
use App\Core\Module\ModuleTrait;

final class BlogModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'blog';
    public const ENABLE = true;
    public const LOCALIZE = true;
}
