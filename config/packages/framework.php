<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'framework',
        [
            'secret' => (string) param('env(APP_SECRET)'),
            'session' => [
                'handler_id' => null,
                'cookie_secure' => 'auto',
                'cookie_samesite' => 'lax',
                'storage_factory_id' => 'session.storage.factory.native'
            ],
            'php_errors' => [
                'log' => true
            ],
            'csrf_protection' => [
                'enabled' => true
            ]
        ]
    );
};
