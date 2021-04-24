<?php

declare(strict_types=1);

namespace App\Contact\Validator\Rule;

use App\Core\Validator\RuleInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactMessageRule implements RuleInterface
{
    public static function rules(): array
    {
        return [
            new NotBlank()
        ];
    }
}
