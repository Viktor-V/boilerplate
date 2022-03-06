<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\All;

use App\Admin\Application\UseCase\Query\DTO\AdminDTO;
use App\Common\Application\Query\QueryHandlerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Generator;

final class AllHandler implements QueryHandlerInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(AllQuery $query): Generator
    {
        $sql = <<<EOF
            SELECT uuid, email, created_at, updated_at FROM admin
            LIMIT :limit OFFSET :page;
        EOF;

        $statement = $this->connection->prepare($sql);
        $statement->bindValue('limit', $query->limit);
        $statement->bindValue('page', $query->page - 1);

        $rows = $statement->executeQuery()->fetchAllAssociative();
        foreach ($rows as $row) {
            yield new AdminDTO(
                $row['uuid'],
                $row['email'],
                $row['created_at'],
                $row['updated_at'],
            );
        }

        return (int) $this->connection->prepare('SELECT COUNT(*) FROM admin')->executeQuery()->fetchOne();
    }
}
