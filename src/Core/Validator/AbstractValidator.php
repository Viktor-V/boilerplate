<?php

declare(strict_types=1);

namespace App\Core\Validator;

use Symfony\Component\Validator\Validation;

abstract class AbstractValidator implements ValidatorInterface, RuleInterface
{
    public static function validate(mixed $value): bool
    {
        $messages = Validation::createValidator()->validate($value, static::rules());

        if ($messages->count()) {
            throw ValidatorException::throwException($messages);
        }

        return true;
    }
}
