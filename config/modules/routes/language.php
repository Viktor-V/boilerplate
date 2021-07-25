<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\ModuleInterface;
use App\Admin\AdminModule;
use App\AntiSpam\AntiSpamModule;
use App\Language\LanguageModule;
use App\ErrorPage\ErrorPageModule;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $excludeModules = [
        LanguageModule::class,
        ErrorPageModule::class,
        AntiSpamModule::class,
        AdminModule::class
    ];

    $contents = require __DIR__ . '/../../modules.php';
    foreach ($contents as $class) {
        if (\in_array($class, $excludeModules, true)) {
            continue;
        }

        /** @var ModuleInterface $module */
        $module = new $class();
        if ($module->enabled()) {
            $routingConfigurator
                ->import(
                    __DIR__ . '/../../../src/' . ucfirst($module->name()) . '/Infrastructure/Controller/',
                    'annotation'
                )
                ->prefix('/{_locale}')
                ->requirements(['_locale' => (string) param('language.locales')])
                ->defaults(['_locale' => (string) param('language.default')]);
        }
    }

    $routingConfigurator
        ->add('nolocale', '/')
        ->controller('Symfony\Bundle\FrameworkBundle\Controller\RedirectController::urlRedirectAction')
        ->defaults(['path' => '/' . (string) param('language.default')])
        ->methods(['GET']);
};
