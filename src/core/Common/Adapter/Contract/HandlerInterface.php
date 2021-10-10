<?php

declare(strict_types=1);

namespace App\Core\Common\Adapter\Contract;

use App\Core\Common\ValueObject\Contract\RequestObjectInterface;

interface HandlerInterface
{
    public function handle(RequestObjectInterface $requestData): void;
}
