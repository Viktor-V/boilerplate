<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'cache' => [
            'pools' => [
                'core.cache.default' => [
                    'adapter' => 'cache.adapter.array',
                    'provider' => null
                ]
            ]
        ]
    ]);
};
