<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $from = sprintf(
        '%s %s <%s>',
        (string) param('project'),
        _('Support'),
        (string) param('core.mailer.email')
    );

    $containerConfigurator->extension('framework', [
        'mailer' => [
            'dsn' => (string) param('core.mailer.dsn'),
            'headers' => [
                'from' => $from
            ]
        ]
    ]);
};
