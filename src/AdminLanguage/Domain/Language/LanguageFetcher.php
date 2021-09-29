<?php

declare(strict_types=1);

namespace App\AdminLanguage\Domain\Language;

use App\AdminLanguage\Domain\Entity\LanguageEntity;
use App\AdminLanguage\Domain\Language\View\LanguageView;
use Doctrine\DBAL\Connection;
use Generator;

final class LanguageFetcher
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function all(): Generator
    {
        $data = $this->connection
            ->createQueryBuilder()
            ->select('*')
            ->from(LanguageEntity::TABLE_NAME)
            ->orderBy('prime', 'desc')
            ->addOrderBy('code', 'asc')
            ->execute()
            ->fetchAllAssociative();

        foreach ($data as $row) {
            yield LanguageView::initialize($row);
        }
    }
}
