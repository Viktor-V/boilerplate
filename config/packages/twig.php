<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->extension('twig', [
        'default_path' => param('kernel.project_dir') . '/templates',
        'globals' => [
            'project' => param('project'),
            'support' => param('core.mailer.email')
        ],
        'form_themes' => [
            'bootstrap_4_layout.html.twig',
            'core/form/bootstrap.html.twig'
        ]
    ]);
};
