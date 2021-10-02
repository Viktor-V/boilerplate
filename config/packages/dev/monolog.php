<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('monolog', [
        'handlers' => [
            'main' => [
                'type' => 'stream',
                'path' => (string)new ParamConfigurator('kernel.logs_dir') . '/'
                    . (string)new ParamConfigurator('kernel.environment') . '.log',
                'level' => 'debug',
                'channels' => ['!event']
            ],
            'console' => [
                'type' => 'console',
                'process_psr_3_messages' => false,
                'channels' => ['!event', '!doctrine', '!console']
            ]
        ]
    ]);
};
