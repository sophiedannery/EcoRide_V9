<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527090325 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // 1. Add the "user" relation column (nullable)
        $this->addSql('ALTER TABLE suspension ADD COLUMN user_id INT DEFAULT NULL');
        // 2. Index it
        $this->addSql('CREATE INDEX IDX_SUSPENSION_USER_ID ON suspension (user_id)');
        // 3. Foreign key -> user(id), cascade on delete
        $this->addSql(<<<'SQL'
        ALTER TABLE suspension
        ADD CONSTRAINT FK_SUSPENSION_USER
            FOREIGN KEY (user_id)
            REFERENCES `user` (id)
            ON DELETE CASCADE
    SQL);

        // 4. Add the "admini" relation column (nullable)
        $this->addSql('ALTER TABLE suspension ADD COLUMN admini_id INT DEFAULT NULL');
        // 5. Index it
        $this->addSql('CREATE INDEX IDX_SUSPENSION_ADMINI_ID ON suspension (admini_id)');
        // 6. Foreign key -> user(id), restrict on delete
        $this->addSql(<<<'SQL'
        ALTER TABLE suspension
        ADD CONSTRAINT FK_SUSPENSION_ADMINI
            FOREIGN KEY (admini_id)
            REFERENCES `user` (id)
            ON DELETE RESTRICT
    SQL);
    }

    public function down(Schema $schema): void
    {
        // Reverse order: drop FKs first, then indexes, then columns

        // 1. Drop admini FK
        $this->addSql('ALTER TABLE suspension DROP FOREIGN KEY FK_SUSPENSION_ADMINI');
        // 2. Drop admini index
        $this->addSql('DROP INDEX IDX_SUSPENSION_ADMINI_ID ON suspension');
        // 3. Drop admini column
        $this->addSql('ALTER TABLE suspension DROP COLUMN admini_id');

        // 4. Drop user FK
        $this->addSql('ALTER TABLE suspension DROP FOREIGN KEY FK_SUSPENSION_USER');
        // 5. Drop user index
        $this->addSql('DROP INDEX IDX_SUSPENSION_USER_ID ON suspension');
        // 6. Drop user column
        $this->addSql('ALTER TABLE suspension DROP COLUMN user_id');
    }
}
