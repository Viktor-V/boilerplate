<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('monolog', [
        'handlers' => [
            'main' => [
                'type' => 'fingers_crossed',
                'action_level' => 'error',
                'handler' => 'nested',
                'excluded_http_codes' => [404, 405],
                'channels' => ['!event']
            ],
            'nested' => [
                'type' => 'stream',
                'path' => param('kernel.logs_dir') . '/' . param('kernel.environment') . '.log',
                'level' => 'debug'
            ]
        ]
    ]);
};
