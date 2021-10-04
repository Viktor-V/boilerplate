<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Admin\AdminLanguage\Domain\Language\LanguageFetcher;
use App\Admin\AdminLanguage\Domain\Language\LanguageRepository;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\Admin\AdminLanguage\\', __DIR__ . '/../../src/admin/AdminLanguage/')
        ->exclude([
            __DIR__ . '/../../src/admin/AdminLanguage/{DependencyInjection,Domain}',
            __DIR__ . '/../../src/admin/AdminLanguage/ValueObject/LanguageEditRequestData.php',
        ]);

    $services->load(
        'App\Admin\AdminLanguage\Infrastructure\Controller\\',
        __DIR__ . '/../../src/admin/AdminLanguage/Infrastructure/Controller/'
    )->tag('controller.service_arguments');

    $services->set(LanguageRepository::class);
    $services->set(LanguageFetcher::class);
};
