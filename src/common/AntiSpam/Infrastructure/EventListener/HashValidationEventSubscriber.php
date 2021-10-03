<?php

declare(strict_types=1);

namespace App\Common\AntiSpam\Infrastructure\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class HashValidationEventSubscriber implements EventSubscriberInterface
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

        if (!$form->isRoot()) {
            return;
        }

        $data = $event->getData();

        $concatenatedValues = null;
        foreach ($data as $field => $value) {
            if ($field !== $this->field) {
                $concatenatedValues .= $value;
            }
        }

        $hashedForm = md5((string) $concatenatedValues);
        if ($hashedForm !== $data[$this->field]) {
            $this->logger->warning(sprintf(
                'Bot detected. IP: %s; User Agent: %s; Spam detector: %s',
                $this->request->getClientIp(),
                $this->request->headers->get('User-Agent'),
                self::class
            ));

            $form->addError(new FormError(_('Oops. Something went wrong. Please, try later.')));
        }

        if (\is_array($data)) {
            unset($data[$this->field]);

            $event->setData($data);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }
}
