<?php

declare(strict_types=1);

namespace UI\Back\Request\Admin;

use App\Admin\Domain\Entity\ValueObject\PlainPassword;
use Symfony\Component\Validator\Constraints as Assert;
use UI\Back\Form\Admin\CreateForm;
use UI\Common\Payload\AbstractFormPayload;

/** TODO: remove getters? */

class CreatePayload extends AbstractFormPayload
{
    public const PAYLOAD_FORM = CreateForm::class;

    #[Assert\NotBlank]
    #[Assert\Email]
    public ?string $email = null;

    #[Assert\NotBlank]
    #[Assert\Length(min: PlainPassword::MIN_PASSWORD_LENGTH)]
    public ?string $password = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function fromArray(array $params): void
    {
        parent::fromArray($params);

        if (isset($params['email'])) {
            $this->email = $params['email'];
        }

        if (isset($params['password'])) {
            $this->password = $params['password'];
        }
    }

    public function toArray(): array
    {
        return array_merge(
            parent::toArray(),
            [
                'email' => $this->getEmail(),
                'password' => $this->getPassword()
            ]
        );
    }
}
