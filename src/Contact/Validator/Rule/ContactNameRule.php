<?php

declare(strict_types=1);

namespace App\Contact\Validator\Rule;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ContactNameRule implements RuleInterface
{
    public static function rules(): array
    {
        return [
            new NotBlank()
        ];
    }
}
