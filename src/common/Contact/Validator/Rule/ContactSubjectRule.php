<?php

declare(strict_types=1);

namespace App\Common\Contact\Validator\Rule;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactSubjectRule implements RuleInterface
{
    private const MIN_SUBJECT_LENGTH = 2;

    public static function rules(): array
    {
        return [
            new NotBlank([
                'message' => __('%s is a required value.', _('Subject'))
            ]),
            new Length([
                'min' => self::MIN_SUBJECT_LENGTH,
                'minMessage' => __(
                    '%s is too short. It should have %s characters or more.',
                    _('Subject'),
                    self::MIN_SUBJECT_LENGTH
                )
            ])
        ];
    }
}
