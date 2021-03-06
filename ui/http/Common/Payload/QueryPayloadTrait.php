<?php

declare(strict_types=1);

namespace UI\Http\Common\Payload;

use Symfony\Component\Validator\Constraints as Assert;

trait QueryPayloadTrait
{
    #[Assert\Positive]
    #[DefaultValue(self::DEFAULT_PAGE)]
    public readonly int $page;

    #[Assert\Positive]
    #[Assert\Choice(choices: self::DEFAULT_LIMIT_CHOICE)]
    #[DefaultValue(self::DEFAULT_LIMIT)]
    public readonly int $limit;

    #[Assert\Regex(self::AVAILABLE_CHARS)]
    #[DefaultValue(null)]
    public readonly ?string $sort;

    #[Assert\Choice(choices: self::DEFAULT_DIRECTION)]
    #[DefaultValue(null)]
    public readonly ?string $direction;
}
