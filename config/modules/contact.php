<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Common\Contact\Adapter\ContactHandler;
use App\Common\Contact\Infrastructure\Controller\ContactController;
use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('contact.social', [
        'facebook' => 'https://facebook.com',
        'instagram' => 'https://instagram.com',
        'twitter' => 'https://twitter.com'
    ]);

    $containerConfigurator->extension('twig', [
        'globals' => [
            'social' => (string) new ParamConfigurator('contact.social')
        ],
    ]);

    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\Common\Contact\\', __DIR__ . '/../../src/common/Contact/')
        ->exclude(__DIR__ . '/../../src/common/Contact/{Domain}');
    $services
        ->load(
            'App\Common\Contact\Infrastructure\Controller\\',
            __DIR__ . '/../../src/common/Contact/Infrastructure/Controller/'
        )
        ->tag('controller.service_arguments');

    $services->set(ContactController::class)
        ->arg('$supportEmail', (string) new ParamConfigurator('contact.support.email'))
        ->arg('$supportPhone', (string) new ParamConfigurator('contact.support.phone'));

    $services->set(ContactHandler::class)
        ->arg('$support', (string) new ParamConfigurator('contact.support.email'));

    // Config values
    $parameters->set('contact.support.email', (string) new ParamConfigurator('env(resolve:CONTACT_SUPPORT_EMAIL)'));
    $parameters->set('contact.support.phone', (string) new ParamConfigurator('env(resolve:CONTACT_SUPPORT_PHONE)'));

    // Default environment values
    $parameters->set('env(CONTACT_SUPPORT_EMAIL)', 'user@example.com');
    $parameters->set('env(CONTACT_SUPPORT_PHONE)', '570-687-9437');
};
