<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

use App\Common\Domain\Assert\QueryAssertion;

final class Offset
{
    private int $offset;

    public function __construct(
        int $offset
    ) {
        QueryAssertion::positiveInteger($offset);

        $this->offset = $offset;
    }

    public function toNumber(): int
    {
        return $this->offset - 1;
    }
}
