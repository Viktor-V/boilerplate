<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('debug', [
        'dump_destination' => 'tcp://' . (string) new ParamConfigurator('env(VAR_DUMPER_SERVER)'),
    ]);
};
