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
        return [
            new NotBlank([
                'message' => __('%s is a required value.', _('Email'))
            ]),
            new Email([
                'message' => _('Email is not valid.')
            ])
        ];
    }
}
