<?php

declare(strict_types=1);

namespace App\Core\Common\Validator\Rule\Core;

use App\Core\Common\Validator\Contract\RuleInterface;
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
