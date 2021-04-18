<?php

declare(strict_types=1);

use App\Language\Infrastructure\Twig\LanguageExtension;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $languageData = [
        'en' => ['name' => 'English', 'native' => 'English', 'default' => true],
        'ru' => ['name' => 'Russian', 'native' => 'Русский', 'default' => false]
    ];

    $defaultLocale = 'en';
    foreach ($languageData as $locale => $data) {
        if ($data['default'] === true) {
            $defaultLocale = $locale;
        }
    }

    $parameters = $containerConfigurator->parameters();
    $parameters->set('language.data', $languageData);
    $parameters->set('language.locale', implode('|', array_keys($languageData)));
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
        ->arg('$languageData', '%language.data%');
};
