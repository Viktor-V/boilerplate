<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Common\ErrorPage\Infrastructure\Controller\ErrorController;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'error_controller' => ErrorController::class
    ]);

    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\Common\ErrorPage\\', __DIR__ . '/../../src/common/ErrorPage/');

    $services
        ->load(
            'App\Common\ErrorPage\Infrastructure\Controller\\',
            __DIR__ . '/../../src/common/ErrorPage/Infrastructure/Controller/'
        )
        ->tag('controller.service_arguments');
};
