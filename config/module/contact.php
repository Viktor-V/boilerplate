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

    $services->load('App\Contact\\', __DIR__ . '/../../src/Contact/');

    $services->load('App\Contact\Infrastructure\Controller\\', __DIR__ . '/../../src/Contact/Infrastructure/Controller/')
        ->tag('controller.service_arguments');
};
