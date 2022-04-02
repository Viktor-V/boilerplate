<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Event\AdminCreated;

use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Common\Domain\Event\EventHandlerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class SendWelcomeEmailHandler implements EventHandlerInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private string $infoEmail
    ) {
    }

    public function __invoke(AdminCreatedEvent $event): void
    {
        $email = (new Email())
            ->from($this->infoEmail)
            ->to($event->getEmail()->toString())
            ->subject('Welcome to the team!') // TODO: trans
            ->html(
                <<<EOF
                    <h1>Welcome to the team!</h1>
                    <p>A new user account has been created for you. Your new username is {$event->getEmail()->toString()}</p>
                    <p>Please click <a href="#">here</a> to set your password and log in.</p>
                EOF
            ); // TODO: trans

        $this->mailer->send($email);
    }
}
