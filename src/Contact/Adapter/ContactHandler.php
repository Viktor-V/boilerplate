<?php

declare(strict_types=1);

namespace App\Contact\Adapter;

use App\Contact\Domain\ContactEntity;
use App\Contact\Domain\Field\ContactEmailField;
use App\Contact\Domain\Field\ContactMessageField;
use App\Contact\Domain\Field\ContactNameField;
use App\Contact\Domain\Field\ContactSubjectField;
use App\Contact\ValueObject\ContactRequestData;
use App\Core\Adapter\Contract\HandlerInterface;
use App\Core\Validator\ValidatorException;
use App\Core\ValueObject\Contract\RequestDataInterface;

final class ContactHandler implements HandlerInterface
{
    /**
     * @throws ValidatorException
     */
    public function handle(RequestDataInterface $requestData): void
    {
        /** @var ContactRequestData $requestData */
        $contact = ContactEntity::init(
            new ContactNameField($requestData->name),
            new ContactEmailField($requestData->email),
            new ContactSubjectField($requestData->subject),
            new ContactMessageField($requestData->message),
        );
    }
}
