<?php

declare(strict_types=1);

namespace App\Common\Contact\Adapter;

use App\Common\Contact\Domain\ContactEntity;
use App\Common\Contact\Domain\Field\ContactEmailField;
use App\Common\Contact\Domain\Field\ContactMessageField;
use App\Common\Contact\Domain\Field\ContactNameField;
use App\Common\Contact\Domain\Field\ContactSubjectField;
use App\Common\Contact\ValueObject\ContactRequestData;
use App\Core\Common\Adapter\Contract\HandlerInterface;
use App\Core\Common\Validator\Exception\ValidatorException;
use App\Core\Common\ValueObject\Contract\RequestDataInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Psr\Log\LoggerInterface;

final class ContactHandler implements HandlerInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private LoggerInterface $logger,
        private string $support
    ) {
    }

    /**
     * @throws ValidatorException|TransportExceptionInterface
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

        try {
            $this->mailer->send(
                (new Email())
                    ->replyTo(new Address((string) $contact->getEmail(), (string) $contact->getName()))
                    ->to($this->support)
                    ->subject((string) $contact->getSubject())
                    ->text((string) $contact->getMessage())
            );
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error('Cannot send email to support. Reason: ' . $exception->getMessage());

            throw $exception;
        }

        try {
            $this->mailer->send(
                (new TemplatedEmail())
                    ->to((string) $contact->getEmail())
                    ->subject(_('Request received'))
                    ->htmlTemplate('contact/mail/confirmation.html.twig')
                    ->context(['contact' => $contact])
            );
        } catch (TransportExceptionInterface $exception) {
            $this->logger->error(
                'Cannot send confirmation email to sender . Reason: ' . $exception->getMessage()
            );

            throw $exception;
        }
    }
}
