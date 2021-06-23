<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'url' => null,
                'dbname' => 'main_test' . (string) param('env(default::TEST_TOKEN)')
            ]
        ]
    );
};
