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

if (!function_exists('_a')) {
    function _a(string $message): string
    {
        return _($message);
    }
}

if (!function_exists('__a')) {
    function __a(string $message, mixed ...$values): string
    {
        return __($message, ...$values);
    }
}

if (!function_exists('camelize')) {
    function camelize(string $snakeCase): string
    {
        return str_replace('_', '', ucwords($snakeCase, '_'));
    }
}
