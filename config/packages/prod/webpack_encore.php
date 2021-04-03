<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    /*$containerConfigurator->extension('webpack_encore', [
        // Cache the entrypoints.json (rebuild Symfony's cache when entrypoints.json changes)
        // Available in version 1.2
        'cache' => true
    ]);*/
};
