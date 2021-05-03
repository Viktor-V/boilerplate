<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'framework',
        [
            'messenger' => [
                //'failure_transport' => 'failed',

                'transports' => [
                    'async' => [
                        'dsn' => '%core.transport.dsn%',
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
