<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('webpack_encore', [
        'output_path' => param('kernel.project_dir') . '/public/build',
        'script_attributes' => ['defer' => true],
    ]);
};
