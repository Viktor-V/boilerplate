<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Common\Language\Infrastructure\Twig\LanguageExtension;
use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $languages = [
        'en' => ['name' => 'English', 'native' => 'English', 'prime' => true]
    ];

    $defaultLocale = 'en';
    foreach ($languages as $locale => $language) {
        if ($language['prime'] === true) {
            $defaultLocale = $locale;
        }
    }

    $parameters = $containerConfigurator->parameters();
    $parameters->set('language.languages', $languages);
    $parameters->set('language.locales', implode('|', array_keys($languages)));
    $parameters->set('language.prime', $defaultLocale);

    $services = $containerConfigurator->services();
    $services
        ->defaults()
        ->autowire()
        ->autoconfigure()
        ->public();

    $services->load('App\Common\Language\\', __DIR__ . '/../../src/common/Language/');

    $services
        ->set(LanguageExtension::class)
        ->arg('$languages', (string) new ParamConfigurator('language.languages'));
};
