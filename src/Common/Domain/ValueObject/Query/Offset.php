<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

use App\Common\Domain\Assert\QueryAssertion;

final class Offset
{
    private ?int $offset;

    public function __construct(
        ?int $offset
    ) {
        if ($offset !== null) {
            QueryAssertion::positiveInteger($offset);
        }

        $this->offset = $offset;
    }

    public function toNumber(): ?int
    {
        if (!$this->offset) {
            return null;
        }

        return $this->offset - 1;
    }
}
