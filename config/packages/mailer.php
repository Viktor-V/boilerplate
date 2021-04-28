<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'mailer' => [
            'dsn' => '%core.mailer.dsn%',
            'headers' => [
                'from' => 'Support <%core.mailer.email%>',
            ],
        ]
    ]);
};