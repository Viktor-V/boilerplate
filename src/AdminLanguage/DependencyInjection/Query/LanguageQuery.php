<?php

declare(strict_types=1);

namespace App\AdminLanguage\DependencyInjection\Query;

use App\AdminLanguage\Domain\Entity\LanguageEntity;
use App\Core\Common\DependencyInjection\Query\Contract\QueryInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\Exception as DoctrineDriverException;
use Doctrine\DBAL\Exception as DoctrineException;

final class LanguageQuery implements QueryInterface
{
    /**
     * @return array<int, mixed>
     */
    public function fetch(Connection $connection): array
    {
        $queryBuilder = $connection->createQueryBuilder();
        $queryBuilder
            ->select('*')
            ->from(LanguageEntity::TABLE_NAME)
            ->orderBy('prime', 'desc')
            ->addOrderBy('code', 'asc');

        try {
            return $connection
                ->executeQuery($queryBuilder->getSQL())
                ->fetchAllAssociative();
        } catch (DoctrineException | DoctrineDriverException) {
            return [];
        }
    }
}
