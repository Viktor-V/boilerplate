<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'default_connection' => 'default',
                'connections' => [
                    'default' => [
                        'url' => 'sqlite::memory',
                        'driver' => 'pdo_sqlite'
                    ]
                ]
            ]
        ]
    );
};
