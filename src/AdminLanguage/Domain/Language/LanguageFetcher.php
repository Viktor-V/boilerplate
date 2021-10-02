<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language;

use App\AdminLanguage\Domain\Entity\LanguageEntity;
use App\AdminLanguage\Domain\Language\View\LanguageView;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\ForwardCompatibility\DriverStatement;
use Doctrine\DBAL\Driver\Exception as DoctrineDriverException;
use Doctrine\DBAL\Exception as DoctrineException;
use Generator;

final class LanguageFetcher
{
    public function __construct(
        private Connection $connection
    ) {
    }

    /**
     * @return Generator<LanguageView>
     * @throws DoctrineDriverException
     * @throws DoctrineException
     */
    public function all(): Generator
    {
        $driverStatement = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from(LanguageEntity::TABLE_NAME)
            ->orderBy('prime', 'desc')
            ->addOrderBy('code', 'asc')
            ->execute();

        if (!($driverStatement instanceof DriverStatement)) {
            return;
        }

        foreach ($driverStatement->fetchAllAssociative() as $row) {
            yield LanguageView::initialize($row);
        }
    }
}
