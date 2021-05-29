<?php

declare(strict_types=1);

namespace App\AntiSpam\Infrastructure\EventListener;

use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Psr\Log\LoggerInterface;

// If user in last 10 ($attemptLastTime) minutes sends 10 ($attemptCount) requests
// Prevent him from sending requests for 1 hour
class AttemptValidationEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Request $request,
        private CacheInterface $cache,
        private LoggerInterface $logger,
        private int $attemptCount,
        private int $attemptLastTime
    ) {
    }

    public function postSubmit(FormEvent $event): void
    {
        /** @var AdapterInterface $cache */
        $cache = $this->cache;

        $form = $event->getForm();
        if (!$form->isRoot()) {
            return;
        }

        if (!$form->isValid()) {
            return;
        }

        $fingerprint = $this->fingerprint($this->request);

        /** @var ItemInterface $item */
        $item = $cache->getItem('attempt_count_' . $fingerprint);
        if ($item->get() >= $this->attemptCount - 1) {
            $this->logger->warning(sprintf(
                'Bot detected. IP: %s; User Agent: %s; Spam detector: %s',
                $this->request->getClientIp(),
                $this->request->headers->get('User-Agent'),
                self::class
            ));

            $form->addError(new FormError(
                _('You have sent too many requests in a given amount of time. Please, try again after 1 hour.')
            ));

            return;
        }

        $lastSessionRequest = $this->request->getSession()->get('last_session_request_' . $fingerprint);
        if ($lastSessionRequest > time() - $this->attemptLastTime) {
            $item->set($item->get() + 1);
            $item->expiresAfter(600);
            $cache->save($item);
        }

        $this->request->getSession()->set('last_session_request_' . $fingerprint, time());
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::POST_SUBMIT => [['postSubmit', -100]]
        ];
    }

    private function fingerprint(Request $request): string
    {
        return md5($request->getClientIp() . $request->headers->get('User-Agent'));
    }
}
