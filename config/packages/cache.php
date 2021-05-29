<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'cache' => [
            'default_redis_provider' => param('core.cache.redis.provider'),
            'pools' => [
                'redis_pool' => [
                    'adapter' => 'cache.adapter.redis',
                    'provider' => 'cache.default_redis_provider'
                ]
            ]
        ]
    ]);
};
