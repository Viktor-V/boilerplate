<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

use App\Common\Domain\Assert\QueryAssertion;

final class Limit
{
    public const DEFAULT_LIMIT = 1;
    public const DEFAULT_LIMIT_CHOICE = [1, 50, 100];

    private int $limit;

    public function __construct(
        int $limit
    ) {
        QueryAssertion::inArray($limit, self::DEFAULT_LIMIT_CHOICE);

        $this->limit = $limit;
    }

    public function toNumber(): ?int
    {
        return $this->limit;
    }
}
