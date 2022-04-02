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

        if ($query->likeEmail) {
            $queryBuilder->andWhere('email LIKE :likeEmail');
            $queryBuilder->setParameter('likeEmail', $query->likeEmail->toString());
        }

        if ($query->startCreatedAt && $query->endCreatedAt) {
            $queryBuilder->andWhere('created_at BETWEEN :startCreatedAt AND :endCreatedAt');
            $queryBuilder->setParameter('startCreatedAt', $query->startCreatedAt->format('Y-m-d'));
            $queryBuilder->setParameter('endCreatedAt', $query->endCreatedAt->format('Y-m-d'));
        }

        if ($query->sort && $query->direction) {
            $queryBuilder->orderBy((string) $query->sort, (string) $query->direction);
        } else {
            $queryBuilder->orderBy('created_at', 'DESC');
        }


        $queryBuilder->setFirstResult($query->offset->toNumber());
        $queryBuilder->setMaxResults($query->limit->toNumber());

        $rows = $queryBuilder->executeQuery()->fetchAllAssociative();
        foreach ($rows as $row) {
            yield new AdminDTO(
                (string) $row['uuid'],
                (string) $row['email'],
                (string) $row['created_at'],
                (string) $row['updated_at']
            );
        }

        $queryBuilder
            ->resetQueryPart('orderBy')
            ->setMaxResults(null);

        return (int) $queryBuilder
            ->select('COUNT(*)')
            ->from('admin')
            ->executeQuery()
            ->fetchOne();
    }
}
