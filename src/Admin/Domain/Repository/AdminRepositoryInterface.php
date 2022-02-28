<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Admin\Domain\Entity\Admin;

interface AdminRepositoryInterface
{
    public function save(Admin $admin): void;
}
