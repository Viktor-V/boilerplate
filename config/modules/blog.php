<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->load('App\Blog\\', __DIR__ . '/../../src/Blog/');

    $services
        ->load(
            'App\Blog\Infrastructure\Controller\\',
            __DIR__ . '/../../src/Blog/Infrastructure/Controller/'
        )
        ->tag('controller.service_arguments');
};
