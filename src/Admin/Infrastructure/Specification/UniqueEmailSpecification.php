<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Specification;

use App\Admin\Domain\Entity\ValueObject\Email;
use App\Admin\Domain\Repository\AdminRepositoryInterface;
use App\Admin\Domain\Specification\UniqueEmailSpecificationInterface;

class UniqueEmailSpecification implements UniqueEmailSpecificationInterface
{
    public function __construct(
        private AdminRepositoryInterface $adminRepository
    ) {
    }

    public function isSatisfiedBy(Email $email): bool
    {
        return $this->adminRepository->findByEmail($email) === null;
    }
}
