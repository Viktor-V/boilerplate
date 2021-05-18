<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\ErrorPage\Infrastructure\Controller\ErrorController;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'error_controller' => 'App\ErrorPage\Infrastructure\Controller\ErrorController::show'
    ]);

    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\ErrorPage\\', __DIR__ . '/../../src/ErrorPage/');

    $services->load('App\ErrorPage\Infrastructure\Controller\\', __DIR__ . '/../../src/ErrorPage/Infrastructure/Controller/')
        ->tag('controller.service_arguments');
};
