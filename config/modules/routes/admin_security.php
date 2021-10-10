<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Admin\AdminCache\AdminCacheModule;
use App\Core\Admin\Infrastructure\Controller\AbstractController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $module = new AdminCacheModule();

    if (!$module->enable()) {
        return;
    }

    $routingConfigurator
        ->import(
            __DIR__ . '/../../../src/admin/AdminSecurity/Infrastructure/Controller/',
            'annotation'
        )
        ->prefix('/' . AbstractController::ADMIN_CORE_PATH);
};
