<?php

declare(strict_types=1);

namespace App\Admin\Domain\Specification;

use App\Admin\Domain\Entity\ValueObject\Email;

interface UniqueEmailSpecificationInterface
{
    public function isSatisfiedBy(Email $email): bool;
}
