<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection\Query;

use Doctrine\DBAL\Connection;

interface QueryInterface
{
    public function fetch(Connection $connection): array;
}
