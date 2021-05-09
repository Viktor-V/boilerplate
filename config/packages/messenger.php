<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'framework',
        [
            'messenger' => [
                //'failure_transport' => 'failed',

                'transports' => [
                    'async' => [
                        'dsn' => param('core.transport.dsn'),
                        'retry_strategy' => [
                            'max_retries' => 3
                        ]
                    ],

                    /*'failed' => [
                        'dsn' => 'doctrine://default?queue_name=failed',
                    ]*/
                ],

                'routing' => [
                    \Symfony\Component\Mailer\Messenger\SendEmailMessage::class => 'async'
                ]
            ]
        ]
    );
};
