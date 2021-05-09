<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $from = sprintf(
        '%s %s <%s>',
        param('project'),
        _('Support'),
        param('core.mailer.email')
    );

    $containerConfigurator->extension('framework', [
        'mailer' => [
            'dsn' => param('core.mailer.dsn'),
            'headers' => [
                'from' => $from
            ]
        ]
    ]);
};
