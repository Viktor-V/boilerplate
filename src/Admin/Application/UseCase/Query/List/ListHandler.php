<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\List;

use App\Admin\Application\UseCase\Query\DTO\AdminDTO;
use App\Common\Application\Query\QueryHandlerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Generator;

final class ListHandler implements QueryHandlerInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(ListQuery $query): Generator
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from('admin');

        if ($query->likeEmail->toString()) {
            $queryBuilder->andWhere('email LIKE :likeEmail');
            $queryBuilder->setParameter('likeEmail', $query->likeEmail->toString());
        }

        $queryBuilder->setFirstResult($query->offset->toNumber());
        $queryBuilder->setMaxResults($query->limit->toNumber());

        $rows = $queryBuilder->executeQuery()->fetchAllAssociative();
        foreach ($rows as $row) {
            yield new AdminDTO(
                $row['uuid'],
                $row['email'],
                $row['created_at'],
                $row['updated_at']
            );
        }

        return (int) $queryBuilder
            ->select('COUNT(*)')
            ->from('admin')
            ->setFirstResult(null)
            ->setMaxResults(null)
            ->executeQuery()
            ->fetchOne();
    }
}
