<?php

declare(strict_types=1);

namespace App\Common\Contact\Domain\Field;

use App\Common\Contact\Validator\Rule\ContactSubjectRule;
use App\Core\Validator\Validator;
use App\Core\Validator\Exception\ValidatorException;

final class ContactSubjectField
{
    /** @throws ValidatorException */
    public function __construct(
        private string|null $subject
    ) {
        Validator::validate($subject, ContactSubjectRule::rules());
    }

    public function __toString(): string
    {
        return (string) $this->subject;
    }
}
