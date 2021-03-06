<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Command\Create;

use App\Admin\Application\Service\PasswordEncoderInterface;
use App\Admin\Domain\Entity\Admin;
use App\Admin\Domain\Repository\AdminRepositoryInterface;
use App\Admin\Domain\Specification\UniqueEmailSpecificationInterface;
use App\Common\Application\Command\CommandHandlerInterface;

final class CreateHandler implements CommandHandlerInterface
{
    public function __construct(
        private PasswordEncoderInterface $passwordEncoder,
        private UniqueEmailSpecificationInterface $uniqueEmailSpecification,
        private AdminRepositoryInterface $adminRepository
    ) {
    }

    public function __invoke(CreateCommand $command): void
    {
        $admin = Admin::create(
            $command->uuid,
            $command->email,
            $this->passwordEncoder->encode($command->password),
            $this->uniqueEmailSpecification
        );

        $this->adminRepository->save($admin);
    }
}
