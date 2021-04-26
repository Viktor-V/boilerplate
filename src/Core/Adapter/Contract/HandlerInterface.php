<?php

declare(strict_types=1);

namespace App\Core\Adapter\Contract;

use App\Core\ValueObject\Contract\RequestDataInterface;

interface HandlerInterface
{
    public function handle(RequestDataInterface $requestData): void;
}
