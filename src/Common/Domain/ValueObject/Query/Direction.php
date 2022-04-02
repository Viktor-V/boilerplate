<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

use App\Common\Domain\Assert\QueryAssertion;

final class Direction
{
    public const DEFAULT_DIRECTION = ['asc', 'desc'];

    private ?string $direction;

    public function __construct(
        ?string $direction
    ) {
        if ($direction !== null) {
            QueryAssertion::inArray($direction, self::DEFAULT_DIRECTION);
        }

        $this->direction = $direction;
    }

    public function toString(): ?string
    {
        return $this->direction;
    }

    public function __toString(): string
    {
        return (string) $this->toString();
    }
}
