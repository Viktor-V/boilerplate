<?php

declare(strict_types=1);

namespace App\Core\Domain;

use Doctrine\ORM\EntityManagerInterface;

final class Flusher
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
