<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

final class Like
{
    private ?string $like;

    public function __construct(
        ?string $like
    ) {
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
