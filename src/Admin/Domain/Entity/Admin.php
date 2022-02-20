<?php

declare(strict_types=1);

namespace App\Admin\Domain\Entity;

use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Admin\Domain\Specification\PasswordEncoderInterface;
use App\Admin\Domain\Specification\UniqueEmailInterface;
use App\Admin\Domain\ValueObject\Email;
use App\Admin\Domain\ValueObject\Password;
use App\Admin\Domain\ValueObject\PlainPassword;
use App\Common\Domain\Entity\Aggregate;
use App\Common\Domain\ValueObject\UuidInterface;
use DateTimeImmutable;
use DomainException;

class Admin extends Aggregate
{
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    private function __construct(
        private UuidInterface $uuid,
        private Email $email,
        private Password $password
    ) {
        $this->createdAt = new DateTimeImmutable();
    }

    public static function create(
        UuidInterface $uuid,
        Email $email,
        PlainPassword $password,
        UniqueEmailInterface $uniqueEmail,
        PasswordEncoderInterface $passwordEncoder
    ): self {
        if ($uniqueEmail->isUnique($email)) {
            throw new DomainException(sprintf('Admin %s already exists.', $email->toString()));
        }

        $admin = new self($uuid, $email, $passwordEncoder->encode($password));
        $admin->raise(new AdminCreatedEvent($uuid, $email));

        return $admin;
    }
}