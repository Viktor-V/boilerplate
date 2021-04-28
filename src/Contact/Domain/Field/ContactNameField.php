<?php

declare(strict_types=1);

namespace App\Contact\Domain\Field;

use App\Contact\Validator\Rule\ContactNameRule;
use App\Core\Validator\Validator;

final class ContactNameField
{
    public function __construct(
        private string|null $name
    ) {
        Validator::validate($name, ContactNameRule::rules());
    }

    public function __toString(): string
    {
        return (string) $this->name;
    }
}