<?php

declare(strict_types=1);

namespace UI\Http\Common\Payload;

use App\Common\Domain\ValueObject\Query\Limit;

interface QueryPayloadInterface extends PayloadInterface
{
    public const DEFAULT_PAGE = 1;
    public const DEFAULT_LIMIT = Limit::DEFAULT_LIMIT;
    public const DEFAULT_LIMIT_CHOICE = Limit::DEFAULT_LIMIT_CHOICE;
}
