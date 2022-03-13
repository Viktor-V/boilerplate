<?php

declare(strict_types=1);

namespace App\Common\Domain\ValueObject\Query;

use App\Common\Domain\Assert\Assertion;

final class Limit
{
    public const DEFAULT_LIMIT = 1;
    public const DEFAULT_LIMIT_CHOICE = [1, 50, 100];

    private ?int $limit;

    public function __construct(
        ?int $limit
    ) {
        if ($limit !== null) {
            Assertion::inArray($limit, self::DEFAULT_LIMIT_CHOICE);
        }

        $this->limit = $limit;
    }

    public function toNumber(): ?int
    {
        if (!$this->limit) {
            return null;
        }

        return $this->limit;
    }
}
