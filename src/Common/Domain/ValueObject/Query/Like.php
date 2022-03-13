<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

use App\Common\Domain\Assert\Assertion;

final class Like
{
    private ?string $like;

    public function __construct(
        ?string $like
    ) {
        if ($like !== null) {
            Assertion::notEmpty($like);
        }

        $this->like = $like;
    }

    public function toString(): ?string
    {
        if (!$this->like) {
            return null;
        }

        return '%' . $this->like . '%';
    }

    public function __toString(): string
    {
        return (string) $this->toString();
    }
}
