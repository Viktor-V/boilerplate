<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\AdminLanguage\Domain\Language\LanguageFetcher;
use App\AdminLanguage\Domain\Language\LanguageRepository;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services
        ->load('App\AdminLanguage\\', __DIR__ . '/../../src/AdminLanguage/')
        ->exclude([
            __DIR__ . '/../../src/AdminLanguage/{DependencyInjection,Domain}',
            __DIR__ . '/../../src/AdminLanguage/ValueObject/LanguageEditRequestData.php',
        ]);

    $services->load(
        'App\AdminLanguage\Infrastructure\Controller\\',
        __DIR__ . '/../../src/AdminLanguage/Infrastructure/Controller/'
    )->tag('controller.service_arguments');

    $services->set(LanguageRepository::class);
    $services->set(LanguageFetcher::class);
};
