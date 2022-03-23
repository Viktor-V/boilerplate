<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Request;

use UI\Http\Common\Payload\AbstractPayload;
use UI\Http\Common\Payload\DefaultValue;
use UI\Http\Common\Payload\QueryPayloadInterface;
use UI\Http\Common\Payload\QueryPayloadTrait;
use Symfony\Component\Validator\Constraints as Assert;

class ListPayload extends AbstractPayload implements QueryPayloadInterface
{
    use QueryPayloadTrait;

    #[DefaultValue(null)]
    public readonly ?string $likeEmail;

    #[Assert\DateTime(format: 'd.m.Y')]
    #[DefaultValue(null)]
    public readonly ?string $startCreatedAt;

    #[Assert\DateTime(format: 'd.m.Y')]
    #[DefaultValue(null)]
    public readonly ?string $endCreatedAt;
}
