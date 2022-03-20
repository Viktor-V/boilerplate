<?php

declare(strict_types=1);

namespace UI\Http\Common\EventSubscriber;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use UI\Http\Common\ParamConverter\FormParamConverter;
use UI\Http\Common\ParamConverter\PayloadParamConverter;
use UI\Http\Common\Payload\FormPayloadInterface;

class FormSubscriber implements EventSubscriberInterface
{
    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        if (!$event->getRequest()->isMethod(Request::METHOD_POST)) {
            return;
        }

        $payload = $event->getRequest()->attributes->get(PayloadParamConverter::NAME);
        if (!$payload instanceof FormPayloadInterface) {
            return;
        }

        $form = $event->getRequest()->attributes->get(FormParamConverter::NAME);
        if (!$form instanceof FormInterface) {
            return;
        }

        dump($payload);

        $form->submit($payload->toArray());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerArgumentsEvent::class => 'onKernelControllerArguments'
        ];
    }
}
