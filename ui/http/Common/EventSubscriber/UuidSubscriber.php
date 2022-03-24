<?php

declare(strict_types=1);

namespace UI\Http\Common\EventSubscriber;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UuidSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ValidatorInterface $validator
    ) {
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->isMethod(Request::METHOD_GET)) {
            return;
        }

        if (!$request->attributes->has('uuid')) {
            return;
        }

        $errors = $this->validator->validate($request->attributes->get('uuid'), [new Assert\Uuid()]);
        if ($errors->count()) {
            throw new NotFoundHttpException();
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => 'onKernelRequest'
        ];
    }
}
