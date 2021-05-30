<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();

    $parameters->set('project', 'Boilerplate');

    // Config values
    $parameters->set('core.mailer.dsn', param('env(resolve:CORE_MAILER_DSN)'));
    $parameters->set('core.mailer.email', param('env(string:CORE_MAILER_EMAIL)'));

    $parameters->set('core.transport.dsn', param('env(resolve:CORE_TRANSPORT_DSN)'));

    $parameters->set('core.db.dsn', param('env(resolve:CORE_DB_DSN)'));

    $parameters->set('core.redis.dsn', param('env(resolve:CORE_REDIS_DSN)'));

    // Default environment values
    $parameters->set('env(CORE_MAILER_DSN)', 'smtp://mailhog:1025');
    $parameters->set('env(CORE_MAILER_EMAIL)', 'user@example.com');

    $parameters->set('env(CORE_TRANSPORT_DSN)', 'amqp://guest:guest@rabbitmq:5672/%2f/messages');

    $parameters->set(
        'env(CORE_DB_DSN)',
        'mysql://root:root@mariadb:3306/localhost?serverVersion=mariadb-10.4.18'
    );

    $parameters->set('env(CORE_REDIS_DSN)', 'redis://redis:6379');
};
