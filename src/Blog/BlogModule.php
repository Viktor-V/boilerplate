<?php

declare(strict_types=1);

namespace App\Blog;

use App\ModuleInterface;

final class BlogModule implements ModuleInterface
{
    public const NAME = 'blog';
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
