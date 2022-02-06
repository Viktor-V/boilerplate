<?php

declare(strict_types=1);

namespace App\Admin\Domain\Event;

use App\Admin\Domain\Entity\Admin;
use App\Common\Domain\Event\EventInterface;

class AdminCreatedEvent implements EventInterface
{
    public function __construct(
        private Admin $admin
    ) {}

    public function getAdmin(): Admin
    {
        return $this->admin;
    }
}