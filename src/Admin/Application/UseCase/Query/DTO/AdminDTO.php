<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\DTO;

final class AdminDTO
{
    public function __construct(
        public readonly string $uuid,
        public readonly string $email,
        public readonly string $createdAt,
        public readonly ?string $updatedAt = null
    ) {
    }
}
