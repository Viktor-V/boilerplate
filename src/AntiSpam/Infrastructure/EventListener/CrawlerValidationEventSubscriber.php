<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\EventListener;

use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;

class CrawlerValidationEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private CrawlerDetect $crawlerDetect,
        private Request $request,
        private LoggerInterface $logger
    ) {
    }

    public function preSubmit(FormEvent $event): void
    {
        $form = $event->getForm();

        if ($form->isRoot() && $this->crawlerDetect->isCrawler()) {
            $this->logger->warning(sprintf(
                'Bot detected. IP: %s; User Agent: %s; Spam detector: %s',
                $this->request->getClientIp(),
                $this->request->headers->get('User-Agent'),
                self::class
            ));

            $form->addError(new FormError(_('Oops. Something went wrong. Please, try later.')));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }
}
