<?php

declare(strict_types=1);

namespace App\Admin\Domain\Event;

use App\Admin\Domain\ValueObject\Email;
use App\Common\Domain\Event\EventInterface;
use App\Common\Domain\ValueObject\UuidInterface;

class AdminCreatedEvent implements EventInterface
{
    public function __construct(
        private UuidInterface $uuid,
        private Email $email
    ) {}

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}