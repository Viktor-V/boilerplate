<?php

declare(strict_types=1);

if (!function_exists('_')) {
    function _(string $message): string
    {
        return __($message, []);
    }
}

if (!function_exists('__')) {
    function __(string $message, mixed ...$values): string
    {
        return sprintf($message, ...$values);
    }
}
