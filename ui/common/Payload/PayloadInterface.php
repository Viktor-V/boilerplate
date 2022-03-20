<?php

declare(strict_types=1);

namespace UI\Common\Payload;

interface PayloadInterface
{
    public function fromArray(array $params): self;
    public function toArray(): array;
}
