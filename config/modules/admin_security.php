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
        ->load('App\AdminSecurity\\', __DIR__ . '/../../src/AdminSecurity/');

    $services->load(
        'App\AdminSecurity\Infrastructure\Controller\\',
        __DIR__ . '/../../src/AdminSecurity/Infrastructure/Controller/'
    )->tag('controller.service_arguments');

    $containerConfigurator->extension('security', [
        'providers' => [
            'admins_in_memory' => ['memory' => true]
        ],
        'access_control' => [
            ['path' => '^/admin', 'roles' => 'ROLE_ADMIN'],
        ]
    ]);
};
