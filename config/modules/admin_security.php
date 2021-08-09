<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AdminSecurity\Infrastructure\Security\FormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\PlaintextPasswordHasher;
use Symfony\Component\Security\Core\Encoder\PasswordHasherEncoder;
use Symfony\Component\Security\Core\User\InMemoryUser;

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
