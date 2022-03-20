<?php

declare(strict_types=1);

namespace UI\Back\Request\Admin;

use UI\Common\Payload\AbstractPayload;
use UI\Common\Payload\DefaultValue;
use UI\Common\Payload\QueryPayloadInterface;
use UI\Common\Payload\QueryPayloadTrait;

class ListPayload extends AbstractPayload implements QueryPayloadInterface
{
    use QueryPayloadTrait;

    #[DefaultValue(null)]
    public readonly ?string $likeEmail;
}
