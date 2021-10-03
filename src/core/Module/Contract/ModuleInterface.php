<?php

declare(strict_types=1);

namespace App\Core\Module\Contract;

interface ModuleInterface
{
    public function name(): string;
    public function enable(): bool;
    public function localize(): bool;
}
