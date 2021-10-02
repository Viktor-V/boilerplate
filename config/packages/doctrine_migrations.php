<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine_migrations',
        [
            'migrations_paths' => [
                'DoctrineMigrations' => (string) new ParamConfigurator('kernel.project_dir') . '/migrations'
            ],
            'enable_profiler' => (string) new ParamConfigurator('kernel.debug')
        ]
    );
};
