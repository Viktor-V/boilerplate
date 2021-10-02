<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'cache' => [
            'default_redis_provider' => (string) new ParamConfigurator('core.redis.dsn'),
            'pools' => [
                'core.cache.default' => [
                    'adapter' => 'cache.adapter.redis',
                    'provider' => 'cache.default_redis_provider'
                ]
            ]
        ]
    ]);
};
