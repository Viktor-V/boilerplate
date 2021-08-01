<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\AdminCore\\', __DIR__.'/../../src/AdminCore/');

    $services->load('App\AdminCore\Infrastructure\Controller\\',
        __DIR__.'/../../src/AdminCore/Infrastructure/Controller/'
    )
        ->tag('controller.service_arguments');
};
