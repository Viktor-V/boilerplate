<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure();

    $services->load('App\Core\\', __DIR__ . '/../../src/Core/');

    $services->load('App\Core\Infrastructure\Controller\\', __DIR__ . '/../../src/Core/Infrastructure/Controller/')
        ->tag('controller.service_arguments');
};
