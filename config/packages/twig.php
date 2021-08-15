<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('twig', [
        'default_path' => (string) param('kernel.project_dir') . '/templates',
        'globals' => [
            'project' => (string) param('project')
        ],
        'form_themes' => [
            'bootstrap_4_layout.html.twig',
            'core/form/bootstrap.html.twig'
        ]
    ]);
};
