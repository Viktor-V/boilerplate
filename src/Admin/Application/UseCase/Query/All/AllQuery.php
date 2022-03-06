<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\All;

use App\Common\Application\Query\QueryInterface;

class AllQuery implements QueryInterface
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_LIMIT = 10;

    public function __construct(
        public readonly int $page = self::DEFAULT_PAGE,
        public readonly int $limit = self::DEFAULT_LIMIT
    ) {
    }
}
