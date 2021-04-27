<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set('project', 'Boilerplate');

    // Config values
    $parameters->set('core.mailer.dsn', '%env(resolve:CORE_MAILER_DSN)%');
    $parameters->set('core.mailer.email', '%env(string:CORE_MAILER_EMAIL)%');

    // Default environment values
    $parameters->set('env(CORE_MAILER_DSN)', 'smtp://mailhog:1025');
    $parameters->set('env(CORE_MAILER_EMAIL)', 'user@example.com');
};
