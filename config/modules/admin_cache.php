<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AdminCache\Infrastructure\Controller\ClearController;
use App\AdminCache\Infrastructure\Controller\WarmController;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\AdminCache\\', __DIR__.'/../../src/AdminCache/');

    $services->load('App\AdminCache\Infrastructure\Controller\\',
        __DIR__.'/../../src/AdminCache/Infrastructure/Controller/'
    )->tag('controller.service_arguments');

    $services->set(ClearController::class)
        ->arg('$environment', (string) env('string:APP_ENV'));

    $services->set(WarmController::class)
        ->arg('$environment', (string) env('string:APP_ENV'));
};
