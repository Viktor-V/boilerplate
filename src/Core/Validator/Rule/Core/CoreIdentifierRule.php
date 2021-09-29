<?php

declare(strict_types=1);

namespace App\Core\Validator\Rule\Core;

use App\Core\Validator\Contract\RuleInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Uuid;

final class CoreIdentifierRule implements RuleInterface
{
    public static function rules(): array
    {
        return [
            new NotBlank(),
            new Uuid()
        ];
    }
}
