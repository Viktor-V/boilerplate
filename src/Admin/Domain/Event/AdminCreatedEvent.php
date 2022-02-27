<?php

declare(strict_types=1);

namespace App\Admin\Domain\Event;

use App\Admin\Domain\Entity\ValueObject\Email;
use App\Common\Domain\Event\EventInterface;
use App\Common\Domain\ValueObject\Uuid;

class AdminCreatedEvent implements EventInterface
{
    public function __construct(
        private Uuid $uuid,
        private Email $email
    ) {
    }

    public function getUuid(): Uuid
    {
        return $this->uuid;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }
}
