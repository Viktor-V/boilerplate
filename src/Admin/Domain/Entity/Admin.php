<?php

declare(strict_types=1);

namespace App\Admin\Domain\Entity;

use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Admin\Domain\ValueObject\Email;
use App\Admin\Domain\ValueObject\PlainPassword;
use App\Common\Domain\Entity\Aggregate;
use App\Common\Domain\ValueObject\UuidInterface;
use DateTimeImmutable;

class Admin extends Aggregate
{
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    private function __construct(
        private UuidInterface $uuid,
        private Email $email,
        private PlainPassword $plainPassword
    ) {
        $this->createdAt = new DateTimeImmutable();
    }

    public static function create(
        UuidInterface $uuid,
        Email $email,
        PlainPassword $password
    ): self {
        $admin = new self($uuid, $email, $password);

        $admin->raise(new AdminCreatedEvent($admin));

        return $admin;
    }
}