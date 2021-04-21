<?php

declare(strict_types=1);

use App\Language\Infrastructure\Twig\LanguageExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $languages = [
        'en' => ['name' => 'English', 'native' => 'English', 'default' => true],
        'ru' => ['name' => 'Russian', 'native' => 'Русский', 'default' => false]
    ];

    $defaultLocale = 'en';
    foreach ($languages as $locale => $language) {
        if ($language['default'] === true) {
            $defaultLocale = $locale;
        }
    }

    $parameters = $containerConfigurator->parameters();
    $parameters->set('language.locales', implode('|', array_keys($languages)));
    $parameters->set('language.default', $defaultLocale);

    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->load('App\Language\\', __DIR__ . '/../../src/Language/');

    $services
        ->set(LanguageExtension::class)
        ->arg('$languages', $languages);
};
