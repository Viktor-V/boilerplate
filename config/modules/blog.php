<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

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
