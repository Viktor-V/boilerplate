<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $importConfigurator = $routingConfigurator->import('@WebProfilerBundle/Resources/config/routing/wdt.xml');
    $importConfigurator->prefix('/_wdt');

    $importConfigurator = $routingConfigurator->import('@WebProfilerBundle/Resources/config/routing/profiler.xml');
    $importConfigurator->prefix('/_profiler');
};
