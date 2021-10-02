<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'assets' => [
            'json_manifest_path' => (string) new ParamConfigurator('kernel.project_dir') . '/public/build/manifest.json'
        ]
    ]);
};
