<?php

declare(strict_types=1);

namespace App\Contact\Validator\Rule;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactEmailRule implements RuleInterface
{
    public static function rules(): array
    {
        $labelName = _('Email');
        return [
            new NotBlank([
                'message' => __('%s is a required value.', $labelName)
            ]),
            new Email([
                'message' => __('%s is not a valid email address.', $labelName)
            ])
        ];
    }
}
