<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AdminSecurity\AdminSecurityModule;
use App\AdminSecurity\Infrastructure\Controller\LogoutController;
use App\AdminSecurity\Infrastructure\Security\FormAuthenticator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $firewalls['dev'] = [
        'pattern' => '^/(_(profiler|wdt)|css|images|js)/',
        'security' => false
    ];

    if ((new AdminSecurityModule())->enable()) {
        $firewalls['admin'] = [
            'lazy' => true,
            'provider' => 'admins_in_memory',
            'custom_authenticators' => [FormAuthenticator::class],
            'logout' => [
                'path' => LogoutController::LOGOUT_ROUTE_NAME
            ]
        ];
    }

    $containerConfigurator->extension('security', [
        'enable_authenticator_manager' => true,
        'firewalls' => $firewalls
    ]);
};
