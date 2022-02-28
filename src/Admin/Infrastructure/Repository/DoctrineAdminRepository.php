<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\Admin;
use App\Admin\Domain\Repository\AdminRepositoryInterface;
use App\Common\Infrastructure\Repository\AbstractDoctrineRepository;

class DoctrineAdminRepository extends AbstractDoctrineRepository implements AdminRepositoryInterface
{
    protected const CLASS_NAME = Admin::class;

    public function save(Admin $admin): void
    {
        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }
}
