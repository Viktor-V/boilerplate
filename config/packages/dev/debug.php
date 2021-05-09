<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('debug', [
        'dump_destination' => 'tcp://' . param('env(VAR_DUMPER_SERVER)'),
    ]);
};
