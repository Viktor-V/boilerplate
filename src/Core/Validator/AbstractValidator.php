<?php

declare(strict_types=1);

namespace App\Core\Validator;

use App\Core\Validator\Contract\RuleInterface;
use App\Core\Validator\Contract\ValidatorInterface;
use Symfony\Component\Validator\Validation;

abstract class AbstractValidator implements ValidatorInterface, RuleInterface
{
    public static function validate(mixed $value): bool
    {
        $messages = Validation::createValidator()->validate($value, static::rules());

        if ($messages->count() !== 0) {
            throw ValidatorException::throwException($messages);
        }

        return true;
    }
}
