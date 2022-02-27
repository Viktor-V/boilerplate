<?php

declare(strict_types=1);

namespace App\Admin\Domain\Specification;

use App\Admin\Domain\Entity\ValueObject\Email;

interface UniqueEmailInterface
{
    public function isUnique(Email $email): bool;
}
