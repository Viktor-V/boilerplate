<?php

declare(strict_types=1);

namespace App\Contact\Domain\Field;

use App\Contact\Validator\Rule\ContactEmailRule;
use App\Core\Validator\Validator;
use App\Core\Validator\Exception\ValidatorException;

final class ContactEmailField
{
    /** @throws ValidatorException */
    public function __construct(
        private string|null $email
    ) {
        Validator::validate($email, ContactEmailRule::rules());
    }

    public function __toString(): string
    {
        return (string) $this->email;
    }
}
