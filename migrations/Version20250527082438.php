<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527082438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // 1. Ajout de la colonne si elle n'existe pas
        $this->addSql(<<<'SQL'
        ALTER TABLE trajet
        ADD COLUMN IF NOT EXISTS chauffeurs_id INT NULL
    SQL);

        // 2. Création de l’index si besoin
        $this->addSql(<<<'SQL'
        CREATE INDEX IF NOT EXISTS IDX_TRAJET_CHAUFFEURS_ID ON trajet (chauffeurs_id)
    SQL);

        // 3. Ajout de la FK si elle n'existe pas
        $this->addSql(<<<'SQL'
        ALTER TABLE trajet
        ADD CONSTRAINT IF NOT EXISTS FK_TRAJET_CHAUFFEURS_ID
            FOREIGN KEY (chauffeurs_id)
            REFERENCES `user` (id)
    SQL);
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trajet DROP FOREIGN KEY FK_TRAJET_CHAUFFEURS_ID');
        $this->addSql('DROP INDEX IDX_TRAJET_CHAUFFEURS_ID ON trajet');
        $this->addSql('ALTER TABLE trajet DROP COLUMN chauffeurs_id');
    }
}
