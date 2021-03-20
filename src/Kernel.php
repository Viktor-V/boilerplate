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
        $container->import('../config/{packages}/*.yaml');
        $container->import('../config/{packages}/' . $this->environment . '/*.yaml');

        $container->import('../config/services.yaml');
        $container->import('../config/{services}_' . $this->environment . '.yaml');

        foreach ($this->getEnabledModules() as $module) {
            $container->import('../config/module/' . $module . '.yaml');
            if (is_file($path = '../config/module/' . $this->environment . '/' . $module . '.yaml')) {
                $container->import($path);
            }
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('../config/{routes}/*.yaml');

        $routes->import('../config/routes.yaml');

        foreach ($this->getEnabledModules() as $module) {
            $routes->import('../config/module/routes/' . $module . '.yaml');
        }
    }

    /**
     * @return array<string>
     */
    private function getEnabledModules(): array
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
