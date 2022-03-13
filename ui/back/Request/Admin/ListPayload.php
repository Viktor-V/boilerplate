<?php

declare(strict_types=1);

namespace UI\Back\Request\Admin;

use Symfony\Component\Validator\Constraints as Assert;
use UI\Common\Payload\AbstractQueryPayload;

class ListPayload extends AbstractQueryPayload
{
    private ?string $likeEmail = null;

    public function getLikeEmail(): ?string
    {
        return $this->likeEmail;
    }

    public function fromArray(array $params): void
    {
        parent::fromArray($params);

        if (isset($params['likeEmail'])) {
            $this->likeEmail = $params['likeEmail'];
        }
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), ['likeEmail' => $this->getLikeEmail()]);
    }
}
