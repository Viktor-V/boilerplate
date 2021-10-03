<?php

declare(strict_types=1);

namespace App\Core\Common\Validator\Contract;

use Symfony\Component\Validator\Constraint;

interface RuleInterface
{
    /**
     * @return array<Constraint>
     */
    public static function rules(): array;
}
