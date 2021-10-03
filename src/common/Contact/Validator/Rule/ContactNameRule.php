<?php

declare(strict_types=1);

namespace App\Common\Contact\Validator\Rule;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactNameRule implements RuleInterface
{
    private const MIN_NAME_LENGTH = 2;

    public static function rules(): array
    {
        return [
            new NotBlank([
                'message' => __('%s is a required value.', _('Name'))
            ]),
            new Length([
                'min' => self::MIN_NAME_LENGTH,
                'minMessage' => __(
                    '%s is too short. It should have %s characters or more.',
                    _('Name'),
                    self::MIN_NAME_LENGTH
                )
            ])
        ];
    }
}
