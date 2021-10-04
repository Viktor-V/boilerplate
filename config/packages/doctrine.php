<?php

declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use App\Admin\AdminLanguage\AdminLanguageModule;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageCodeType;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageIdentifierType;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageNameType;
use App\Admin\AdminLanguage\Domain\Language\Type\LanguageNativeType;
use Symfony\Component\Config\Loader\ParamConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $mappings = $types = [];

    if ((new AdminLanguageModule())->enable()) {
        $types = [
            LanguageIdentifierType::NAME => LanguageIdentifierType::class,
            LanguageCodeType::NAME => LanguageCodeType::class,
            LanguageNameType::NAME => LanguageNameType::class,
            LanguageNativeType::NAME => LanguageNativeType::class
        ];

        $mappings['AdminLanguage'] = [
            'is_bundle' => false,
            'type' => 'attribute',
            'dir' => ((string) new ParamConfigurator('kernel.project_dir')) . '/src/admin/AdminLanguage/Domain/Entity',
            'prefix' => 'App\Admin\AdminLanguage\Domain\Entity',
            'alias' => 'AdminLanguage'
        ];
    }

    $containerConfigurator->extension(
        'doctrine',
        [
            'dbal' => [
                'url' => (string) new ParamConfigurator('core.db.dsn'),
                'server_version' => 'mariadb:10.4.18',
                'types' => $types
            ],
            'orm' => [
                'auto_generate_proxy_classes' => true,
                'naming_strategy' => 'doctrine.orm.naming_strategy.underscore_number_aware',
                'auto_mapping' => true,
                'mappings' => $mappings
            ]
        ]
    );
};
