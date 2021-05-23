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
        ->load('App\AntiSpam\\', __DIR__ . '/../../src/AntiSpam/')
        ->exclude(__DIR__ . '/../../src/AntiSpam/Infrastructure/EventListener/HiddenValidationEventSubscriber.php');
};
