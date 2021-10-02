<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AdminCore\AdminCoreRouteName;
use App\AdminCore\Infrastructure\Controller\AbstractController;
use App\AdminModuleInterface;
use App\ModuleInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $routingConfigurator->import(
        __DIR__ . '/../../../src/AdminCore/Infrastructure/Controller/',
        'annotation'
    );

    $contents = require __DIR__ . '/../../modules.php';
    foreach ($contents as $class) {
        /** @var ModuleInterface $module */
        $module = new $class();

        $isAdminModule = $module instanceof AdminModuleInterface;
        if (!$isAdminModule) {
            continue;
        }

        if ($module->enable()) {
            $routingConfigurator
                ->import(
                    __DIR__ . '/../../../src/' . camelize($module->name()) . '/Infrastructure/Controller/',
                    'annotation'
                )
                ->prefix('/' . AbstractController::ADMIN_CORE_PATH);
        }
    }
};
