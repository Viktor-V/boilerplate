<?php

declare(strict_types=1);

namespace App\Tests\Common\Language\Unit\Infrastructure\Twig;

use App\Common\Language\Infrastructure\Twig\LanguageExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LanguageExtensionTest extends TestCase
{
    private const LANGUAGES = [
        'en' => ['name' => 'English', 'native' => 'English', 'default' => true],
        'ru' => ['name' => 'Russian', 'native' => 'Русский', 'default' => false]
    ];

    public function testLanguagePath(): void
    {
        $locale = 'ru';
        $route = 'contact';
        $expected = '/ru/contact';

        $request = $this->createMock(Request::class);
        $request
            ->method('get')
            ->with('_route')
            ->willReturn($route);

        $attributes = $this->createMock(ParameterBag::class);
        $attributes
            ->method('all')
            ->willReturn(['_route' => $route, '_locale' => 'en']);

        $request->attributes = $attributes;

        $generator = $this->createMock(UrlGeneratorInterface::class);
        $generator
            ->method('generate')
            ->with($route, ['_locale' => $locale])
            ->willReturn('/ru/contact');

        self::assertSame(
            $expected,
            (new LanguageExtension($generator, []))
                ->languagePath($request, 'ru')
        );
    }

    public function testCurrentLanguageName(): void
    {
        $request = $this->createMock(Request::class);
        $request
            ->method('getLocale')
            ->willReturn('ru');

        $languageExtension = new LanguageExtension(
            $this->createMock(UrlGeneratorInterface::class),
            self::LANGUAGES
        );

        self::assertSame('Русский', $languageExtension->currentLanguageName($request));
    }

    public function testLanguages(): void
    {
        $languageExtension = new LanguageExtension(
            $this->createMock(UrlGeneratorInterface::class),
            self::LANGUAGES
        );

        self::assertSame(self::LANGUAGES, $languageExtension->languages());
    }
}
