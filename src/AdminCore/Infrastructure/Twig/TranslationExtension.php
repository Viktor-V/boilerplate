<?php

declare(strict_types=1);

namespace App\AdminCore\Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TranslationExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('_a', static function (string $message): string {
                return _a($message);
            }),

            new TwigFunction('__a', static function (string $message, mixed ...$values): string {
                return __a($message, ...$values);
            }),
        ];
    }
}
