<?php

declare(strict_types=1);

namespace App\Core\Common\Validator;

use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Common\Validator\Contract\ValidatorInterface;
use Symfony\Component\Validator\Validation;

class Validator implements ValidatorInterface
{
    /**
     * @throws ValidatorException
     */
    public static function validate(mixed $value, array $rules): bool
    {
        $messages = Validation::createValidator()->validate($value, $rules);

        if ($messages->count() !== 0) {
            $message = $messages->get(0);

            throw new ValidatorException((string) $message->getMessage());
        }

        return true;
    }
}
