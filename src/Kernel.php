<?php

declare(strict_types=1);

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private ?string $projectDir = null;

    public function getProjectDir(): string
    {
        if ($this->projectDir === null) {
            $this->projectDir = dirname(__DIR__);
        }

        return $this->projectDir;
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import('../config/{packages}/*.php');
        $container->import('../config/{packages}/' . $this->environment . '/*.php');

        $container->import('../config/services.php');
        $container->import('../config/{services}_' . $this->environment . '.php');

        foreach ($this->enabledModules() as $module) {
            $container->import('../config/module/' . $module . '.php');
            if (is_file($path = '../config/module/' . $this->environment . '/' . $module . '.php')) {
                $container->import($path);
            }
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/' . $this->environment . '/*.php');
        $routes->import('../config/{routes}/*.php');

        $routes->import('../config/routes.php');

        foreach ($this->enabledModules() as $module) {
            $routes->import('../config/module/routes/' . $module . '.php');
        }
    }

    /**
     * @return array<string>
     */
    private function enabledModules(): array
    {
        $contents = require $this->getProjectDir() . '/config/modules.php';

        $modules = [];
        foreach ($contents as $class) {
            /** @var ModuleInterface $module */
            $module = new $class();
            if ($module->enabled()) {
                $modules[] = $module->name();
            }
        }

        return $modules;
    }
}
