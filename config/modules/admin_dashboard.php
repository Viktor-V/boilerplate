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
        ->load('App\Admin\AdminDashboard\\', __DIR__ . '/../../src/admin/AdminDashboard/');

    $services->load(
        'App\Admin\AdminDashboard\Infrastructure\Controller\\',
        __DIR__ . '/../../src/admin/AdminDashboard/Infrastructure/Controller/'
    )->tag('controller.service_arguments');
};
