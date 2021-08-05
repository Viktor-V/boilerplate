<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\AdminCore\\', __DIR__ . '/../../src/AdminCore/');

    $services->load(
        'App\AdminCore\Infrastructure\Controller\\',
        __DIR__ . '/../../src/AdminCore/Infrastructure/Controller/'
    )->tag('controller.service_arguments');

    $services->set(Application::class)
        ->arg('$kernel', service(KernelInterface::class));
};
