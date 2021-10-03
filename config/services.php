<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\HttpKernel\KernelInterface;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(__DIR__ . '/parameters.php');

    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\Core\\', __DIR__ . '/../src/core/')
        ->exclude(__DIR__ . '/../src/core/{Validator,DependencyInjection}');
    
    $services->set(Application::class)
        ->arg('$kernel', service(KernelInterface::class));
};
