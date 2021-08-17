<?php

declare(strict_types=1);

namespace App\Blog;

use App\ModuleInterface;
use App\ModuleTrait;

final class BlogModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'blog';
    public const ENABLE = true;
    public const LOCALIZE = true;
}
