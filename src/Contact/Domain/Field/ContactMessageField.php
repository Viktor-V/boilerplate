<?php

declare(strict_types=1);

namespace App\Contact\Domain\Field;

use App\Contact\Validator\Rule\ContactMessageRule;
use App\Core\Validator\Validator;

final class ContactMessageField
{
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
