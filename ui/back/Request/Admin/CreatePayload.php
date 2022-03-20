<?php

declare(strict_types=1);

namespace UI\Back\Request\Admin;

use App\Admin\Domain\Entity\ValueObject\PlainPassword;
use Symfony\Component\Validator\Constraints as Assert;
use UI\Back\Form\Admin\CreateForm;
use UI\Common\Payload\AbstractPayload;
use UI\Common\Payload\DefaultValue;
use UI\Common\Payload\FormPayloadInterface;
use UI\Common\Payload\FormPayloadTrait;

class CreatePayload extends AbstractPayload implements FormPayloadInterface
{
    use FormPayloadTrait;

    public const PAYLOAD_FORM = CreateForm::class;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[DefaultValue(null)]
    public readonly ?string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: PlainPassword::MIN_PASSWORD_LENGTH)]
    #[DefaultValue(null)]
    public readonly ?string $password;
}
