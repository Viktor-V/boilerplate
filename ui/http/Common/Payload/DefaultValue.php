<?php

declare(strict_types=1);

namespace UI\Http\Common\Payload;

use Attribute;

#[Attribute]
final class DefaultValue
{
    public function __construct(
        private mixed $value = null
    ) {
    }
}
