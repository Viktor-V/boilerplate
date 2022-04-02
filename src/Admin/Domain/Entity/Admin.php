<?php

declare(strict_types=1);

namespace App\Admin\Domain\Entity;

use App\Admin\Domain\Entity\ValueObject\Email;
use App\Admin\Domain\Entity\ValueObject\Password;
use App\Admin\Domain\Event\AdminCreatedEvent;
use App\Admin\Domain\Exception\EmailAlreadyExistException;
use App\Admin\Domain\Specification\UniqueEmailSpecificationInterface;
use App\Common\Domain\Entity\Aggregate;
use App\Common\Domain\ValueObject\Uuid;
use DateTimeImmutable;

class Admin extends Aggregate
{
    private DateTimeImmutable $createdAt;
    private ?DateTimeImmutable $updatedAt;

    private function __construct(
        private Uuid $uuid,
        private Email $email,
        private Password $password,
        private UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ) {
        if (!$uniqueEmailSpecification->isSatisfiedBy($email)) {
            throw new EmailAlreadyExistException(
                sprintf('Admin already exists with such email %s.', $email->toString())
            );
        }

        $this->createdAt = new DateTimeImmutable();
        $this->updatedAt = null;
    }

    public static function create(
        Uuid $uuid,
        Email $email,
        Password $password,
        UniqueEmailSpecificationInterface $uniqueEmailSpecification
    ): self {
        $admin = new self($uuid, $email, $password, $uniqueEmailSpecification);
        $admin->raise(new AdminCreatedEvent($uuid, $email));

        return $admin;
    }
}
