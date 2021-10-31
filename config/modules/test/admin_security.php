<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Tests\AdminConstant;
use Symfony\Component\Security\Core\User\InMemoryUser;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('security', [
        'password_hashers' => [
            InMemoryUser::class => 'plaintext'
        ],
        'providers' => [
            'admins_in_memory' => [
                'memory' => [
                    'users' => [
                        AdminConstant::ADMIN_USERNAME => [
                            'password' => AdminConstant::ADMIN_PASSWORD,
                            'roles' => ['ROLE_ADMIN']
                        ]
                    ]
                ]
            ]
        ]
    ]);
};
