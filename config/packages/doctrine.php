<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'url' => (string) param('core.db.dsn'),
                'server_version' => 'mariadb:10.4.18'
            ],
            'orm' => [
                'auto_generate_proxy_classes' => true,
                'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                'auto_mapping' => true,
                'mappings' => [
                    /*'App' => [
                        'is_bundle' => false,
                        'type' => 'annotation',
                        'dir' => (string) param('kernel.project_dir') . '/src/Entity',
                        'prefix' => 'App\Entity',
                        'alias' => 'App'
                    ]*/
                ]
            ]
        ]
    );
};
