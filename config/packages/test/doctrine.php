<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'url' => null,
                'dbname' => 'main_test' . (string) new ParamConfigurator('env(default::TEST_TOKEN)')
            ]
        ]
    );
};
