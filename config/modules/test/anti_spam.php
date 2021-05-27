<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AntiSpam\Infrastructure\Form\Extension\FormTypeCrawlerExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHashExtension;
use App\AntiSpam\Infrastructure\Form\Extension\FormTypeHiddenExtension;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services
        ->set(FormTypeHiddenExtension::class)
        ->arg('$enabled', false);

    $services
        ->set(FormTypeCrawlerExtension::class)
        ->arg('$enabled', false);

    $services
        ->set(FormTypeHashExtension::class)
        ->arg('$enabled', false);
};
