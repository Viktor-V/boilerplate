<?php

declare(strict_types=1);

namespace App;

interface ModuleInterface
{
    public function name(): string;
    public function enabled(): bool;
}
