<?php

declare(strict_types=1);

namespace App\Common\Domain\Assert;

class QueryAssertion extends Assertion
{
    protected static function reportInvalidArgument($message)
    {
        throw new InvalidQueryParamException($message);
    }
}
