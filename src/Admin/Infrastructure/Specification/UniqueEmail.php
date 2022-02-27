<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Specification;

use App\Admin\Domain\Entity\ValueObject\Email;
use App\Admin\Domain\Specification\UniqueEmailInterface;

class UniqueEmail implements UniqueEmailInterface
{
    public function isUnique(Email $email): bool
    {
        return true;
    }
}
