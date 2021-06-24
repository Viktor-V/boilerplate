<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', [
        'test' => true,
        'assets' => ['json_manifest_path' => null],
        'session' => [
            'storage_factory_id' => 'session.storage.factory.mock_file'
        ]
    ]);
};
