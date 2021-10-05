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
        ->load('App\Common\Home\\', __DIR__ . '/../../src/common/Home/')
        ->exclude(__DIR__ . '/../../src/common/Home/{Validator,DependencyInjection}');

    $services
        ->load(
            'App\Common\Home\Infrastructure\Controller\\',
            __DIR__ . '/../../src/common/Home/Infrastructure/Controller/'
        )
        ->tag('controller.service_arguments');
};
