<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AdminSecurity\AdminSecurityModule;

return static function (ContainerConfigurator $containerConfigurator): void {
    $firewalls = [];

    if (AdminSecurityModule::ENABLE) {
        $firewalls['admin'] = [
            'lazy' => true,
            'provider' => 'admins_in_memory',
            'http_basic' => true
        ];
    }

    $containerConfigurator->extension('security', [
        'enable_authenticator_manager' => true,
        'firewalls' => $firewalls
    ]);
};
