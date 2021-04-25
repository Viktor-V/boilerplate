<?php

declare(strict_types=1);

namespace App\Core\Validator;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Exception;

class ValidatorException extends Exception
{
    /**
     * @var iterable<ConstraintViolationInterface>
     */
    private iterable $messages;

    /**
     * @param iterable<ConstraintViolationInterface> $messages
     */
    public function __construct(
        iterable $messages
    ) {
        $this->messages = $messages;

        parent::__construct('', 500, null);
    }

    /**
     * @param iterable<ConstraintViolationInterface> $messages
     */
    public static function throwException(iterable $messages): self
    {
        return new self($messages);
    }

    /**
     * @return iterable<ConstraintViolationInterface>
     */
    public function messages(): iterable
    {
        return $this->messages;
    }
}
