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

    $services
        ->load('App\Core\\', __DIR__ . '/../../src/Core/')
        ->exclude(__DIR__ . '/../../src/Core/Validator');

    $services->load('App\Core\Infrastructure\Controller\\', __DIR__ . '/../../src/Core/Infrastructure/Controller/')
        ->tag('controller.service_arguments');
};
