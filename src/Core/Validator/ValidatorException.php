<?php

declare(strict_types=1);

namespace App\Core\Validator;

use Exception;
use Throwable;

class ValidatorException extends Exception
{
    private iterable $messages;

    public function __construct(
        iterable $messages,
        string $message = "",
        int $code = 0,
        Throwable $previous = null
    ) {
        $this->messages = $messages;

        parent::__construct($message, $code, $previous);
    }

    public static function throwException(iterable $messages): self
    {
        return new self($messages);
    }

    public function messages(): iterable
    {
        return $this->messages;
    }
}
