<?php

declare(strict_types=1);

namespace App\Core\Validator\Contract;

interface ValidatorInterface
{
    public static function validate(mixed $value): bool;
}
