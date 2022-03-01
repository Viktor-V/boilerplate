<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Query\All;

use App\Admin\Application\UseCase\Query\DTO\AdminDTO;
use App\Common\Application\Query\QueryHandlerInterface;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;

final class AllHandler implements QueryHandlerInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @throws Exception
     */
    public function __invoke(AllQuery $query): iterable
    {
        $sql = <<<EOF
            SELECT uuid, email, created_at, updated_at FROM admin;
        EOF;

        $rows = $this->connection->prepare($sql)->executeQuery()->fetchAllAssociative();

        foreach ($rows as $row) {
            yield new AdminDTO(
                $row['uuid'],
                $row['email'],
                $row['created_at'],
                $row['updated_at'],
            );
        }
    }
}
