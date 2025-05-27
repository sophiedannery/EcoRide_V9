<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527083055 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // 1. Ajout de la colonne passagers_id (nullable)
        $this->addSql('ALTER TABLE reservation ADD COLUMN passagers_id INT DEFAULT NULL');

        // 2. Création de l’index sur passagers_id
        $this->addSql('CREATE INDEX IDX_RESERVATION_PASSAGERS_ID ON reservation (passagers_id)');

        // 3. Ajout de la contrainte FK vers user(id)
        $this->addSql(<<<'SQL'
        ALTER TABLE reservation
        ADD CONSTRAINT FK_RESERVATION_PASSAGERS_ID
            FOREIGN KEY (passagers_id)
            REFERENCES `user` (id)
            ON DELETE RESTRICT
    SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // 1. Suppression de la contrainte FK
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_RESERVATION_PASSAGERS_ID');

        // 2. Suppression de l’index
        $this->addSql('DROP INDEX IDX_RESERVATION_PASSAGERS_ID ON reservation');

        // 3. Suppression de la colonne passagers_id
        $this->addSql('ALTER TABLE reservation DROP COLUMN passagers_id');
    }
}
