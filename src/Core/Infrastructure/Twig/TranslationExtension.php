<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TranslationExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('_', static function (string $message) {
                return _($message);
            }),

            new TwigFunction('__', static function (string $message, mixed ...$values) {
                return __($message, $values);
            }),
        ];
    }
}