<?php

declare(strict_types=1);

namespace App\Contact\Validator\Rule;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactSubjectRule implements RuleInterface
{
    public static function rules(): array
    {
        $minLength = 2;

        $labelName = _('Subject');
        return [
            new NotBlank([
                'message' => __('%s is a required value.', $labelName)
            ]),
            new Length([
                'min' => $minLength,
                'minMessage' => __('%s is too short. It should have %s characters or more.', $labelName, $minLength)
            ])
        ];
    }
}
