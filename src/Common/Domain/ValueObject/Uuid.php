<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject;

use App\Common\Domain\Assert\Assertion;

final class Uuid implements UuidInterface
{
    private string $uuid;

    public function __construct(
        string $uuid
    ) {
        Assertion::notEmpty($uuid);
        Assertion::uuid($uuid);

        $this->uuid = $uuid;
    }

    public static function generate(): self
    {
        return new self(\Ramsey\Uuid\Uuid::uuid4()->toString());
    }

    public function toString(): string
    {
        return $this->uuid;
    }

    public function __toString(): string
    {
        return $this->toString();
    }
}
