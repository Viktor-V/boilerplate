<?php

declare(strict_types=1);

use App\Contact\Adapter\ContactHandler;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set('contact.social', [
        'facebook' => 'https://facebook.com',
        'instagram' => 'https://instagram.com',
        'twitter' => 'https://twitter.com'
    ]);

    $containerConfigurator->extension('twig', [
        'globals' => [
            'social' => '%contact.social%'
        ],
    ]);

    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\Contact\\', __DIR__ . '/../../src/Contact/')
        ->exclude(__DIR__ . '/../../src/Contact/{Domain}');
    $services
        ->load(
            'App\Contact\Infrastructure\Controller\\',
            __DIR__ . '/../../src/Contact/Infrastructure/Controller/'
        )
        ->tag('controller.service_arguments');

    $services->set(ContactHandler::class)
        ->arg('$support', '%core.mailer.email%');
};
