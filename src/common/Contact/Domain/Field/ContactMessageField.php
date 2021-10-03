<?php

declare(strict_types=1);

namespace App\Common\Contact\Domain\Field;

use App\Common\Contact\Validator\Rule\ContactMessageRule;
use App\Core\Common\Validator\Validator;
use App\Core\Common\Validator\Exception\ValidatorException;

final class ContactMessageField
{
    /** @throws ValidatorException */
    public function __construct(
        private string|null $message
    ) {
        Validator::validate($message, ContactMessageRule::rules());
    }

    public function __toString(): string
    {
        return (string) $this->message;
    }
}
