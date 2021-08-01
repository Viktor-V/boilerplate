<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\ModuleInterface;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $contents = require __DIR__ . '/../../modules.php';
    foreach ($contents as $class) {
        /** @var ModuleInterface $module */
        $module = new $class();

        if ($module->enable() && $module->localize()) {
            $routingConfigurator
                ->import(
                    __DIR__ . '/../../../src/' . camelize($module->name()) . '/Infrastructure/Controller/',
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
