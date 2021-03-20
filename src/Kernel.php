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

    private const DOMAINS = ['core'];
    private const EXCLUDE_DOMAINS = [];

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

        foreach (self::DOMAINS as $domain) {
            if (in_array($domain, self::EXCLUDE_DOMAINS, true)) {
                continue;
            }

            $container->import('../config/domain/' . $domain . '.yaml');
            if (is_file($path = '../config/domain/' . $this->environment . '/' . $domain . '.yaml')) {
                $container->import($path);
            }
        }
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('../config/{routes}/' . $this->environment . '/*.yaml');
        $routes->import('../config/{routes}/*.yaml');

        $routes->import('../config/routes.yaml');

        foreach (self::DOMAINS as $domain) {
            if (in_array($domain, self::EXCLUDE_DOMAINS, true)) {
                continue;
            }

            $routes->import('../config/domain/routes/' . $domain . '.yaml');
        }
    }
}
