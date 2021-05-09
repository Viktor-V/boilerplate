<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $importConfigurator = $routingConfigurator->import('@FrameworkBundle/Resources/config/routing/errors.xml');

    $importConfigurator->prefix('/_error');
};
