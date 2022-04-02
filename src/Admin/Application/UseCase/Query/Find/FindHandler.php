<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\Find;

use App\Admin\Application\UseCase\Query\DTO\AdminDTO;
use App\Common\Application\Query\QueryHandlerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class FindHandler implements QueryHandlerInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(FindQuery $query): ?AdminDTO
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('admin')
            ->andWhere('uuid = :uuid')
            ->setParameter('uuid', $query->uuid->toString());

        $row = $queryBuilder->executeQuery()->fetchAssociative();
        if ($row === false) {
            return null;
        }

        return new AdminDTO(
            (string) $row['uuid'],
            (string) $row['email'],
            (string) $row['created_at'],
            (string) $row['updated_at']
        );
    }
}
