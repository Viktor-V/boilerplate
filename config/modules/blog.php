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

    $services->load('App\Common\Blog\\', __DIR__ . '/../../src/common/Blog/');

    $services
        ->load(
            'App\Common\Blog\Infrastructure\Controller\\',
            __DIR__ . '/../../src/common/Blog/Infrastructure/Controller/'
        )
        ->tag('controller.service_arguments');
};
