<?php

declare(strict_types=1);

namespace App\ErrorPage;

use App\ModuleInterface;
use App\ModuleTrait;

final class ErrorPageModule implements ModuleInterface
{
    use ModuleTrait;

    public const NAME = 'error_page';

    public function enable(): bool
    {
        return $_SERVER['APP_ENV'] === 'prod';
    }

    public function localize(): bool
    {
        return false;
    }
}
