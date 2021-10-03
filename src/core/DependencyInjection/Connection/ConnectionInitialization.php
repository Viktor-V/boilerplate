<?php

declare(strict_types=1);

namespace App\Core\DependencyInjection\Connection;

use Doctrine\Bundle\DoctrineBundle\ConnectionFactory;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class ConnectionInitialization
{
    public function __construct(
        private ConnectionFactory $connectionFactory
    ) {
    }

    /**
     * @throws Exception
     */
    public function connect(): ?Connection
    {
        if (!isset($_ENV['CORE_DB_DSN'])) {
            return null;
        }

        return $this->connectionFactory->createConnection([
            /* todo: how to get from doctrine.dbal.url? */
            'url' => $_ENV['CORE_DB_DSN']
        ]);
    }
}
