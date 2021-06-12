<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Mailer\Messenger\SendEmailMessage;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'framework',
        [
            'messenger' => [
                'failure_transport' => 'failed',

                'transports' => [
                    'async' => [
                        'dsn' => (string) param('core.transport.dsn'),
                        'retry_strategy' => [
                            'max_retries' => 3
                        ]
                    ],

                    'failed' => [
                        'dsn' => 'doctrine://default?queue_name=failed',
                    ]
                ],

                'routing' => [
                    SendEmailMessage::class => 'async'
                ]
            ]
        ]
    );
};
