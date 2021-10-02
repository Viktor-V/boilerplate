<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $from = sprintf(
        '%s %s <%s>',
        (string) new ParamConfigurator('project'),
        _('Support'),
        (string) new ParamConfigurator('core.mailer.email')
    );

    $containerConfigurator->extension('framework', [
        'mailer' => [
            'dsn' => (string) new ParamConfigurator('core.mailer.dsn'),
            'headers' => [
                'from' => $from
            ]
        ]
    ]);
};
