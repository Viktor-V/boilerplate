<?php

declare(strict_types=1);

namespace UI\Http\Common\Payload;

use App\Common\Domain\ValueObject\Query\Direction;
use App\Common\Domain\ValueObject\Query\Limit;
use App\Common\Domain\ValueObject\Query\Sort;

interface QueryPayloadInterface extends PayloadInterface
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_LIMIT = Limit::DEFAULT_LIMIT;
    public const DEFAULT_LIMIT_CHOICE = Limit::DEFAULT_LIMIT_CHOICE;

    public const AVAILABLE_CHARS = Sort::AVAILABLE_CHARS;
    public const DEFAULT_DIRECTION = Direction::DEFAULT_DIRECTION;
}
