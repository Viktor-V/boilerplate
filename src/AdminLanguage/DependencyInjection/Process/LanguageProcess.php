<?php

declare(strict_types=1);

namespace App\AdminLanguage\DependencyInjection\Process;

use App\Core\DependencyInjection\Process\ProcessInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class LanguageProcess implements ProcessInterface
{
    public function execute(ContainerBuilder $container, array $languages): void
    {
        $languagesData = [];

        foreach ($languages as $language) {
            if ($language['prime'] === true) {
                $container->setParameter('language.prime', $language['code']);
            }

            $languagesData[$language['code']] = [
                'name' => $language['name'],
                'native' => $language['native'],
                'prime' => $language['prime']
            ];
        }

        if (!empty($languagesData)) {
            $container->setParameter('language.languages', $languagesData);
            $container->setParameter('language.locales', implode('|', array_keys($languagesData)));
        }
    }
}
