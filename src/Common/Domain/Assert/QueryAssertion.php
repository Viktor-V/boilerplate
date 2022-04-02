<?php

declare(strict_types=1);

namespace App\Common\Domain\Assert;

class QueryAssertion extends Assertion
{
    /**
     * @psalm-pure this method is not supposed to perform side-effects
     */
    protected static function reportInvalidArgument($message): void
    {
        throw new InvalidQueryParamException($message);
    }
}
