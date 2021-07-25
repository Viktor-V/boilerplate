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
        ->load('App\Admin\\', __DIR__ . '/../../src/Admin/');

    $services->load('App\Admin\Infrastructure\Controller\\', __DIR__ . '/../../src/Admin/Infrastructure/Controller/')
        ->tag('controller.service_arguments');
};
