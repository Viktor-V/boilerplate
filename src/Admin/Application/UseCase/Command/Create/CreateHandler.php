<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Command\Create;

use App\Admin\Application\Service\PasswordEncoderInterface;
use App\Admin\Domain\Entity\Admin;
use App\Admin\Domain\Specification\UniqueEmailInterface;
use App\Common\Application\Command\CommandHandlerInterface;
use Doctrine\ORM\EntityManagerInterface;

class CreateHandler implements CommandHandlerInterface
{
    public function __construct(
        private PasswordEncoderInterface $passwordEncoder,
        private UniqueEmailInterface $uniqueEmail,
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(CreateCommand $command): void
    {
        $admin = Admin::create(
            $command->uuid,
            $command->email,
            $this->passwordEncoder->encode($command->password),
            $this->uniqueEmail
        );

        $this->entityManager->persist($admin);
        $this->entityManager->flush();
    }
}
