<?php

declare(strict_types=1);

namespace App\Common\Contact\Validator\Rule;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactMessageRule implements RuleInterface
{
    private const MIN_MESSAGE_LENGTH = 10;

    public static function rules(): array
    {
        return [
            new NotBlank([
                'message' => __('%s is a required value.', _('Message'))
            ]),
            new Length([
                'min' => self::MIN_MESSAGE_LENGTH,
                'minMessage' => __(
                    '%s is too short. It should have %s characters or more.',
                    _('Message'),
                    self::MIN_MESSAGE_LENGTH
                )
            ])
        ];
    }
}
