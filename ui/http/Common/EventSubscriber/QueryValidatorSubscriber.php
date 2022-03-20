<?php

declare(strict_types=1);

namespace UI\Http\Common\EventSubscriber;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerArgumentsEvent;
use UI\Http\Common\ParamConverter\PayloadParamConverter;
use UI\Http\Common\Payload\QueryPayloadInterface;

class QueryValidatorSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ValidatorInterface $validator,
        private RouterInterface $router
    ) {
    }

    public function onKernelControllerArguments(ControllerArgumentsEvent $event)
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$request->isMethod(Request::METHOD_GET)) {
            return;
        }

        $payload = $request->attributes->get(PayloadParamConverter::NAME);
        if (!$payload instanceof QueryPayloadInterface) {
            return;
        }

        $errors = $this->validator->validate($payload);
        if ($errors->count()) {
            $event->setController(function() use ($request) {
                $request->getSession()->getFlashBag()->add('error', 'Invalid query data.'); // TODO: add trans

                return new RedirectResponse($this->router->generate($request->attributes->get('_route')));
            });
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerArgumentsEvent::class => 'onKernelControllerArguments'
        ];
    }
}
