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
        ->load('App\AdminDashboard\\', __DIR__ . '/../../src/AdminDashboard/');

    $services->load(
        'App\AdminDashboard\Infrastructure\Controller\\',
        __DIR__ . '/../../src/AdminDashboard/Infrastructure/Controller/'
    )->tag('controller.service_arguments');
};
