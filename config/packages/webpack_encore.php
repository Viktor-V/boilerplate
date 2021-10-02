<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('webpack_encore', [
        'output_path' => (string) new ParamConfigurator('kernel.project_dir') . '/public/build',
        'script_attributes' => ['defer' => true],
    ]);
};
