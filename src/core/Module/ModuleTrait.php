<?php

declare(strict_types=1);

namespace App\Core\Module;

trait ModuleTrait
{
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
