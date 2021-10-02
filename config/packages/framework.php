<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'framework',
        [
            'secret' => (string) new ParamConfigurator('env(APP_SECRET)'),
            'session' => [
                'handler_id' => null,
                'cookie_secure' => 'auto',
                'cookie_samesite' => 'lax',
                'storage_factory_id' => 'session.storage.factory.native'
            ],
            'php_errors' => [
                'log' => true
            ],
            'csrf_protection' => true
        ]
    );
};
