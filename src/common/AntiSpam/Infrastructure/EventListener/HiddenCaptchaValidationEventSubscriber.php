<?php

declare(strict_types=1);

namespace App\Common\AntiSpam\Infrastructure\EventListener;

use App\Common\AntiSpam\Exception\HiddenCaptchaException;
use App\Common\AntiSpam\Service\Contract\HiddenCaptchaValidatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Psr\Log\LoggerInterface;

class HiddenCaptchaValidationEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Request $request,
        private HiddenCaptchaValidatorInterface $hiddenCaptchaValidator,
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
        $value = \is_string($data[$this->field] ?? null) ? $data[$this->field] : null;

        try {
            if (!$this->hiddenCaptchaValidator->valid((string) $value)) {
                $this->logger->warning(sprintf(
                    'Bot detected. IP: %s; User Agent: %s; Spam detector: %s',
                    $this->request->getClientIp(),
                    $this->request->headers->get('User-Agent'),
                    self::class
                ));

                $form->addError(new FormError(_('Oops. Something went wrong. Please, try later.')));
            }
        } catch (HiddenCaptchaException $exception) {
            $this->logger->error(sprintf(
                'Hidden captcha service throws error! Type: %s. Error %s',
                get_class($this->hiddenCaptchaValidator),
                $exception->getMessage()
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
