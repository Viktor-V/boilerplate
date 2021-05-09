<?php

declare(strict_types=1);

namespace App\Tests\Contact\Domain;

use App\Contact\Domain\ContactEntity;
use App\Contact\Domain\Field\ContactEmailField;
use App\Contact\Domain\Field\ContactMessageField;
use App\Contact\Domain\Field\ContactNameField;
use App\Contact\Domain\Field\ContactSubjectField;
use App\Core\Validator\ValidatorException;
use PHPUnit\Framework\TestCase;

class ContactEntityTest extends TestCase
{
    public function testPassedInit(): void
    {
        $contact = ContactEntity::init(
            $name = new ContactNameField('Firstname L.'),
            $email = new ContactEmailField('email@example.com'),
            $subject = new ContactSubjectField('This is test subject'),
            $message = new ContactMessageField('This is test message')
        );

        self::assertSame($contact->getName(), $name);
        self::assertSame($contact->getEmail(), $email);
        self::assertSame($contact->getSubject(), $subject);
        self::assertSame($contact->getMessage(), $message);
    }

    public function testFailedInit(): void
    {
        self::expectException(ValidatorException::class);
        self::expectExceptionMessage('Email is not valid.');

        ContactEntity::init(
            new ContactNameField('Firstname L.'),
            new ContactEmailField('email.com'),
            new ContactSubjectField('This is test subject'),
            new ContactMessageField('This is test message')
        );
    }
}
