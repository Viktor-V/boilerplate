<?php

declare(strict_types=1);

namespace App\AdminLanguage\DependencyInjection\Query;

use App\AdminLanguage\Domain\Entity\LanguageEntity;
use App\Core\DependencyInjection\Query\QueryInterface;
use Doctrine\DBAL\Connection;
use Exception;

final class LanguageQuery implements QueryInterface
{
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
                ->executeQuery($queryBuilder)
                ->fetchAllAssociative();
        } catch (Exception) {
            return [];
        }
    }
}
