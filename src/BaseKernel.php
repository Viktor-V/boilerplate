<?php

declare(strict_types=1);

namespace App;

use App\AdminLanguage\DependencyInjection\Compiler\LanguageCompilerPass;
use App\AdminLanguage\DependencyInjection\Process\LanguageProcess;
use App\AdminLanguage\DependencyInjection\Query\LanguageQuery;
use App\Core\DependencyInjection\Connection\ConnectionInitialization;
use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;

final class BaseKernel extends Kernel
{
    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        return dirname(__DIR__);
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->import($this->getProjectDir() . '/config/{packages}/*.php');
        $container->import($this->getProjectDir() . '/config/{packages}/' . $this->environment . '/*.php');

        $container->import($this->getProjectDir() . '/config/services.php');
        $container->import($this->getProjectDir() . '/config/{services}_' . $this->environment . '.php');

        foreach ($this->enabledModules() as $module) {
            $container->import($this->getProjectDir() . '/config/modules/' . $module . '.php');

            $path = $this->getProjectDir() . '/config/modules/' . $this->environment . '/' . $module . '.php';
            if (is_file($path)) {
                $container->import($path);
            }
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import($this->getProjectDir() . '/config/{routes}/' . $this->environment . '/*.php');
        $routes->import($this->getProjectDir() . '/config/{routes}/*.php');

        $routes->import($this->getProjectDir() . '/config/routes.php');

        foreach ($this->enabledModules() as $module) {
            $path = $this->getProjectDir() . '/config/modules/routes/' . $module . '.php';

            if (is_file($path)) {
                $routes->import($path);
            }
        }
    }

    protected function build(ContainerBuilder $container)
    {
        $connectionInitialization = new ConnectionInitialization(new ConnectionFactory([]));

        $container->addCompilerPass(new LanguageCompilerPass(
            $connectionInitialization,
            new LanguageQuery(),
            new LanguageProcess()
        ));
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
            if ($module->enable()) {
                $modules[] = $module->name();
            }
        }

        return $modules;
    }
}
