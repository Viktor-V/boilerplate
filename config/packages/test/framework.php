<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('framework', ['test' => true]);

    $containerConfigurator->extension('framework', ['session' => ['storage_id' => 'session.storage.mock_file']]);
};
