<?php

declare(strict_types=1);

namespace App\Admin\Domain\ValueObject;

final class Sort extends \App\Common\Domain\ValueObject\Query\Sort
{
    protected function availableFields(): array
    {
        return ['email', 'created_at'];
    }
}
