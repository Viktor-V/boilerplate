<?php

declare(strict_types=1);

namespace UI\Common\Payload;

interface PayloadInterface
{
    public function fromArray(array $params): void;
    public function toArray(): array;
}
