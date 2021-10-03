<?php

declare(strict_types=1);

namespace App\Common\Language\Infrastructure\Twig;

use App\Common\Home\Infrastructure\Controller\HomeController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class LanguageExtension extends AbstractExtension
{
    /**
     * @param array<string, mixed> $languages
     */
    public function __construct(
        private UrlGeneratorInterface $generator,
        private array $languages,
    ) {
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('languagePath', [$this, 'languagePath']),
            new TwigFunction('currentLanguageName', [$this, 'currentLanguageName']),
            new TwigFunction('languages', [$this, 'languages']),
        ];
    }

    public function languagePath(Request $request, string $locale): string
    {
        $parameters = $request->attributes->all();
        foreach ($parameters as $key => $parameter) {
            if (str_contains($key, '_')) {
                unset($parameters[$key]);
            }
        }

        return $this->generator->generate(
            $request->get('_route', HomeController::HOME_ROUTE_NAME),
            array_merge($parameters, ['_locale' => $locale])
        );
    }

    public function currentLanguageName(Request $request): string
    {
        return $this->languages[$request->getLocale()]['native'];
    }

    /**
     * @return array<string, mixed> $languageData
     */
    public function languages(): array
    {
        return $this->languages;
    }
}
