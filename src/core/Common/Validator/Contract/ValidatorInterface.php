<?php

declare(strict_types=1);

namespace App\Core\Common\Validator\Contract;

use Symfony\Component\Validator\Constraint;

interface ValidatorInterface
{
    /**
     * @param array<Constraint> $rules
     */
    public static function validate(mixed $value, array $rules): bool;
}
