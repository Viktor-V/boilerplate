<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\All;

use App\Common\Application\Query\QueryInterface;

class AllQuery implements QueryInterface
{
    public function __construct(
        public readonly int $page = 1,
        public readonly int $limit = 10
    ) {
    }
}
