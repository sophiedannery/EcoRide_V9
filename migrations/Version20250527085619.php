<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527085619 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // 1. Ajout de la colonne user_id (nullable)
        $this->addSql('ALTER TABLE `transaction` ADD COLUMN user_id INT DEFAULT NULL');

        // 2. Création de l’index sur user_id
        $this->addSql('CREATE INDEX IDX_TRANSACTION_USER_ID ON `transaction` (user_id)');

        // 3. Ajout de la contrainte FK vers user(id)
        $this->addSql(<<<'SQL'
        ALTER TABLE `transaction`
        ADD CONSTRAINT FK_TRANSACTION_USER
            FOREIGN KEY (user_id)
            REFERENCES `user` (id)
            ON DELETE CASCADE
    SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // 1. Suppression de la contrainte FK
        $this->addSql('ALTER TABLE `transaction` DROP FOREIGN KEY FK_TRANSACTION_USER');

        // 2. Suppression de l’index
        $this->addSql('DROP INDEX IDX_TRANSACTION_USER_ID ON `transaction`');

        // 3. Suppression de la colonne user_id
        $this->addSql('ALTER TABLE `transaction` DROP COLUMN user_id');
    }
}
