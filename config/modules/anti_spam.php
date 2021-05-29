<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AntiSpam\Infrastructure\Form\Extension\FormTypeAttemptExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeCrawlerExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHashExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHiddenExtension;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\AntiSpam\\', __DIR__ . '/../../src/AntiSpam/')
        ->exclude(__DIR__ . '/../../src/AntiSpam/Infrastructure/{EventListener}');

    $services
        ->set(FormTypeHiddenExtension::class)
        ->arg('$enabled', true);

    $services
        ->set(FormTypeCrawlerExtension::class)
        ->arg('$enabled', true);

    $services
        ->set(FormTypeHashExtension::class)
        ->arg('$enabled', true);

    $services
        ->set(FormTypeAttemptExtension::class)
        ->arg('$cache', service('redis_pool'))
        ->arg('$enabled', true)
        ->arg('$attemptCount', 10)
        ->arg('$attemptLastTime', 600);
};
