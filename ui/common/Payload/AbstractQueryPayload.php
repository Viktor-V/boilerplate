<?php

declare(strict_types=1);

namespace UI\Common\Payload;

use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractQueryPayload implements QueryPayloadInterface
{
    #[Assert\Positive]
    protected int $page = self::DEFAULT_PAGE;

    #[Assert\Positive]
    #[Assert\Choice(choices: self::DEFAULT_LIMIT_CHOICE)]
    protected int $limit = self::DEFAULT_LIMIT;

    public function getPage(): int
    {
        return $this->page;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function fromArray(array $params): void
    {
        if (isset($params['page'])) {
            $this->page = (int) $params['page'];
        }

        if (isset($params['limit'])) {
            $this->limit = (int) $params['limit'];
        }
    }

    public function toArray(): array
    {
        return [
            'page' => $this->getPage(),
            'limit' => $this->getLimit()
        ];
    }
}
