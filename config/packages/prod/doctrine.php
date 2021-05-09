<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'orm' => [
                'auto_generate_proxy_classes' => false,
                'metadata_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.system_cache_pool'
                ],
                'query_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.system_cache_pool'
                ],
                'result_cache_driver' => [
                    'type' => 'pool',
                    'pool' => 'doctrine.result_cache_pool'
                ]
            ]
        ]
    );

    $containerConfigurator->extension(
        'framework',
        [
            'cache' => [
                'pools' => [
                    'doctrine.result_cache_pool' => ['adapter' => 'cache.app'],
                    'doctrine.system_cache_pool' => ['adapter' => 'cache.system']
                ]
            ]
        ]
    );
};
