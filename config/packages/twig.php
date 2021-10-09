<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('twig', [
        'default_path' => (string) new ParamConfigurator('kernel.project_dir') . '/templates',
        'globals' => [
            'project' => (string) new ParamConfigurator('project')
        ],
        'form_themes' => [
            'bootstrap_4_layout.html.twig',
            'core/common/form/bootstrap.html.twig'
        ]
    ]);
};
