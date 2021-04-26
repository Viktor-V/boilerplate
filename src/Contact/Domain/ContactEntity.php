<?php

declare(strict_types=1);

namespace App\Contact\Domain;

use App\Contact\Domain\Field\ContactEmailField;
use App\Contact\Domain\Field\ContactMessageField;
use App\Contact\Domain\Field\ContactNameField;
use App\Contact\Domain\Field\ContactSubjectField;

final class ContactEntity
{
    private function __construct(
        private ContactNameField $name,
        private ContactEmailField $email,
        private ContactSubjectField $subject,
        private ContactMessageField $message,
    ) {
    }

    public static function init(
        ContactNameField $name,
        ContactEmailField $email,
        ContactSubjectField $subject,
        ContactMessageField $message,
    ): self {
        return new self($name, $email, $subject, $message);
    }

    public function getName(): ContactNameField
    {
        return $this->name;
    }

    public function getEmail(): ContactEmailField
    {
        return $this->email;
    }

    public function getSubject(): ContactSubjectField
    {
        return $this->subject;
    }

    public function getMessage(): ContactMessageField
    {
        return $this->message;
    }
}
