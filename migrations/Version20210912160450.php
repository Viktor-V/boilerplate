<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210912160450 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create language table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE language (identifier CHAR(36) NOT NULL COMMENT \'(DC2Type:language_identifier)\', code VARCHAR(3) NOT NULL COMMENT \'(DC2Type:language_code)\', name VARCHAR(36) NOT NULL COMMENT \'(DC2Type:language_name)\', native VARCHAR(36) NOT NULL COMMENT \'(DC2Type:language_native)\', `prime` TINYINT(1) DEFAULT \'0\' NOT NULL, PRIMARY KEY(identifier)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE language');
    }
}
