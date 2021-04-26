<?php

declare(strict_types=1);

namespace App\Contact\Domain\Field;

use App\Contact\Validator\Rule\ContactSubjectRule;
use App\Core\Validator\Validator;

final class ContactSubjectField
{
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
