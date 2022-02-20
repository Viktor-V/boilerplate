<?php

declare(strict_types=1);

namespace App\Admin\Domain\Specification;

use App\Admin\Domain\ValueObject\Email;

interface UniqueEmailInterface
{
    public function isUnique(Email $email): bool;
}