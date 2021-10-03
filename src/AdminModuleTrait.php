<?php

declare(strict_types=1);

namespace App;

trait AdminModuleTrait
{
    use ModuleTrait;

    public function enable(): bool
    {
        return true && self::ENABLE;
    }
}
