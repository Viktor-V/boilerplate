<?php

declare(strict_types=1);

namespace UI\Http\Common\Payload;

use Symfony\Component\Validator\Constraints as Assert;

trait FormPayloadTrait
{
    #[Assert\NotBlank]
    #[DefaultValue(null)]
    public readonly ?string $_token;
}
