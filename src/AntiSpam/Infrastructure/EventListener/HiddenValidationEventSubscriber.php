<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\EventListener;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;

class HiddenValidationEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Request $request,
        private LoggerInterface $logger,
        private string $field
    ) {
    }

    public function preSubmit(FormEvent $event): void
    {
        $form = $event->getForm();

        if ($form->isRoot()) {
            $data = $event->getData();

            $value = \is_string($data[$this->field] ?? null) ? $data[$this->field] : null;
            if ($value) {
                $this->logger->warning(sprintf(
                    'Bot detected. IP: %s; User Agent: %s',
                    $this->request->getClientIp(),
                    $this->request->headers->get('User-Agent')
                ));

                $form->addError(new FormError(_('Oops. Something went wrong. Please, try later.')));
            }

            if (\is_array($data)) {
                unset($data[$this->field]);

                $event->setData($data);
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }
}
