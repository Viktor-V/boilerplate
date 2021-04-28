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
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

final class ContactHandler implements HandlerInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private string $support
    ) {
    }

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

        $email = new Email();
        $email->from(new Address((string) $contact->getEmail(), (string) $contact->getName()));
        $email->to($this->support);
        $email->subject((string) $contact->getSubject());
        $email->text((string) $contact->getMessage());

        $confirmationEmail = new TemplatedEmail();
        $confirmationEmail->to((string) $contact->getEmail());

        $subject = _('Request received');
        $confirmationEmail->subject($subject);

        $confirmationEmail->htmlTemplate('contact/mail/confirmation.html.twig');
        $confirmationEmail->context(['contact' => $contact]);

        $this->mailer->send($email);
        $this->mailer->send($confirmationEmail);
    }
}