<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

use App\Common\Domain\Assert\Assertion;

abstract class Sort
{
    public const AVAILABLE_CHARS = '/^[a-z_]+$/';

    private ?string $sort;

    public function __construct(
        ?string $sort
    ) {
        if ($sort !== null) {
            Assertion::regex($sort, '/^[a-z_]+$/');
            Assertion::inArray($sort, $this->availableFields());
        }

        $this->sort = $sort;
    }

    public function toString(): ?string
    {
        return $this->sort;
    }

    public function __toString(): string
    {
        return (string) $this->toString();
    }

    abstract protected function availableFields(): array;
}
