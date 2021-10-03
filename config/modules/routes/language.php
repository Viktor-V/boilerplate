<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Core\Module\Contract\ModuleInterface;
use Symfony\Component\Config\Loader\ParamConfigurator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return static function (RoutingConfigurator $routingConfigurator): void {
    $contents = require __DIR__ . '/../../modules.php';
    foreach ($contents as $class) {
        /** @var ModuleInterface $module */
        $module = new $class();

        if ($module->enable() && $module->localize()) {
            $routingConfigurator
                ->import(
                    __DIR__ . '/../../../src/common/' . camelize($module->name()) . '/Infrastructure/Controller/',
                    'annotation'
                )
                ->prefix('/{_locale}')
                ->requirements(['_locale' => (string) new ParamConfigurator('language.locales')])
                ->defaults(['_locale' => (string) new ParamConfigurator('language.prime')]);
        }
    }

    $routingConfigurator
        ->add('nolocale', '/')
        ->controller('Symfony\Bundle\FrameworkBundle\Controller\RedirectController::urlRedirectAction')
        ->defaults(['path' => '/' . (string) new ParamConfigurator('language.prime')])
        ->methods(['GET']);
};
