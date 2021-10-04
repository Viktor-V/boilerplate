<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Security\Core\User\InMemoryUser;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\Admin\AdminSecurity\\', __DIR__ . '/../../src/admin/AdminSecurity/');

    $services->load(
        'App\Admin\AdminSecurity\Infrastructure\Controller\\',
        __DIR__ . '/../../src/admin/AdminSecurity/Infrastructure/Controller/'
    )->tag('controller.service_arguments');

    $containerConfigurator->extension('security', [
        'password_hashers' => [
            InMemoryUser::class => [
                'algorithm' => 'bcrypt',
                'cost' => 12
            ]
        ],
        'providers' => [
            'admins_in_memory' => [
                'memory' => [
                    'users' => [
                        'admin' => [
                            'password' => '$2y$12$UOzOmBgIX/Xj1/Oe.az8begKT0Czd/Xk/TKcQzbQq.S1cUSkUV/MS',
                            'roles' => ['ROLE_ADMIN']
                        ]
                    ]
                ]
            ]
        ],
        'access_control' => [
            ['path' => '^/admin/auth', 'roles' => 'PUBLIC_ACCESS'],
            ['path' => '^/admin', 'roles' => 'ROLE_ADMIN']
        ]
    ]);
};
