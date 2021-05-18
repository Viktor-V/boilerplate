<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\ModuleInterface;
use App\Language\LanguageModule;
use App\ErrorPage\ErrorPageModule;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $contents = require __DIR__ . '/../../modules.php';
    foreach ($contents as $class) {
        if ($class === LanguageModule::class || $class === ErrorPageModule::class) {
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
                ->requirements(['_locale' => param('language.locales')])
                ->defaults(['_locale' => param('language.default')]);
        }
    }

    $routingConfigurator
        ->add('nolocale', '/')
        ->controller('Symfony\Bundle\FrameworkBundle\Controller\RedirectController::urlRedirectAction')
        ->defaults(['path' => '/' . param('language.default')])
        ->methods(['GET']);
};
