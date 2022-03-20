<?php

declare(strict_types=1);

namespace UI\Http\Back\Admin\Request;

use App\Admin\Domain\Entity\ValueObject\PlainPassword;
use Symfony\Component\Validator\Constraints as Assert;
use UI\Http\Back\Admin\Form\EditForm;
use UI\Http\Common\Payload\AbstractPayload;
use UI\Http\Common\Payload\DefaultValue;
use UI\Http\Common\Payload\FormPayloadInterface;
use UI\Http\Common\Payload\FormPayloadTrait;

class EditPayload extends AbstractPayload implements FormPayloadInterface
{
    use FormPayloadTrait;

    public const PAYLOAD_FORM = EditForm::class;

    #[Assert\NotBlank]
    #[Assert\Email]
    #[DefaultValue(null)]
    public readonly ?string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: PlainPassword::MIN_PASSWORD_LENGTH)]
    #[DefaultValue(null)]
    public readonly ?string $password;
}
