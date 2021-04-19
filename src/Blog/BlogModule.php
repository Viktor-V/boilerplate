<?php

declare(strict_types=1);

namespace App\Blog;

use App\ModuleInterface;

final class BlogModule implements ModuleInterface
{
    public const NAME = 'blog';
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
