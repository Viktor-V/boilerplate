<?php

declare(strict_types=1);

namespace App\ErrorPage;

use App\ModuleInterface;

final class ErrorPageModule implements ModuleInterface
{
    public const NAME = 'error_page';

    public function name(): string
    {
        return self::NAME;
    }

    public function enable(): bool
    {
        return $_SERVER['APP_ENV'] === 'prod';
    }

    public function localize(): bool
    {
        return false;
    }
}
