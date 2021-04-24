<?php

declare(strict_types=1);

namespace App\Core\Validator;

interface RuleInterface
{
    public static function rules(): array;
}
