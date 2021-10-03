<?php

declare(strict_types=1);

namespace App\Core\Common\Adapter\Contract;

use App\Core\Common\ValueObject\Contract\RequestDataInterface;

interface HandlerInterface
{
    public function handle(RequestDataInterface $requestData): void;
}
