<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

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
                'path' => (string)new ParamConfigurator('kernel.logs_dir') . '/'
                    . (string)new ParamConfigurator('kernel.environment') . '.log',
                'level' => 'debug'
            ]
        ]
    ]);
};
