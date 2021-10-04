<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Admin\AdminCache\Infrastructure\Controller\ClearController;
use App\Admin\AdminCache\Infrastructure\Controller\WarmController;
use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\Admin\AdminCache\\', __DIR__ . '/../../src/admin/AdminCache/');

    $services->load(
        'App\Admin\AdminCache\Infrastructure\Controller\\',
        __DIR__ . '/../../src/admin/AdminCache/Infrastructure/Controller/'
    )->tag('controller.service_arguments');

    $services->set(ClearController::class)
        ->arg('$environment', (string) new ParamConfigurator('kernel.environment'));

    $services->set(WarmController::class)
        ->arg('$environment', (string) new ParamConfigurator('kernel.environment'));
};
