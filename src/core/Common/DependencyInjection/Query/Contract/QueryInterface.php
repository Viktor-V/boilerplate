<?php

declare(strict_types=1);

namespace App\Core\Common\DependencyInjection\Query\Contract;

use Doctrine\DBAL\Connection;

interface QueryInterface
{
    /**
     * @return array<int, mixed>
     */
    public function fetch(Connection $connection): array;
}
