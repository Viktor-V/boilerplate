<?php

declare(strict_types=1);

namespace App\Common\Contact\Domain\Field;

use App\Common\Contact\Validator\Rule\ContactNameRule;
use App\Core\Common\Validator\Validator;
use App\Core\Common\Validator\Exception\ValidatorException;

final class ContactNameField
{
    /** @throws ValidatorException */
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
