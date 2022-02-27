<?php

declare(strict_types=1);

namespace App\Admin\Domain\Entity;

use App\Admin\Domain\Entity\ValueObject\Email;
use App\Admin\Domain\Entity\ValueObject\Password;
use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Admin\Domain\Specification\UniqueEmailInterface;
use App\Common\Domain\Entity\Aggregate;
use App\Common\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use DomainException;

class Admin extends Aggregate
{
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    private function __construct(
        private Uuid $uuid,
        private Email $email,
        private Password $password,
        private UniqueEmailInterface $uniqueEmail
    ) {
        if (!$uniqueEmail->isUnique($email)) {
            throw new DomainException(sprintf('Admin %s already exists.', $email->toString()));
        }

        $this->createdAt = new DateTimeImmutable();
    }

    public static function create(
        Uuid $uuid,
        Email $email,
        Password $password,
        UniqueEmailInterface $uniqueEmail
    ): self {
        $admin = new self($uuid, $email, $password, $uniqueEmail);
        $admin->raise(new AdminCreatedEvent($uuid, $email));

        return $admin;
    }
}
