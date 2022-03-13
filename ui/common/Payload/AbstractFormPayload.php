<?php

declare(strict_types=1);

namespace UI\Common\Payload;

use Symfony\Component\Validator\Constraints as Assert;

abstract class AbstractFormPayload implements FormPayloadInterface
{
    #[Assert\NotBlank]
    protected ?string $token = null;

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function fromArray(array $params): void
    {
        if (isset($params['_token'])) {
            $this->token = $params['_token'];
        }
    }

    public function toArray(): array
    {
        return [
            '_token' => $this->getToken()
        ];
    }
}
