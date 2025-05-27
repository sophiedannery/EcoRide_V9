<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527084958 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        // 1. Ajout de la colonne validateur_id (nullable)
        $this->addSql('ALTER TABLE avis ADD COLUMN validateur_id INT DEFAULT NULL');

        // 2. Création de l’index sur validateur_id
        $this->addSql('CREATE INDEX IDX_AVIS_VALIDEUR_ID ON avis (validateur_id)');

        // 3. Ajout de la contrainte FK vers user(id)
        $this->addSql(<<<'SQL'
        ALTER TABLE avis
        ADD CONSTRAINT FK_AVIS_VALIDEUR
            FOREIGN KEY (validateur_id)
            REFERENCES `user` (id)
            ON DELETE SET NULL
    SQL);
    }

    public function down(Schema $schema): void
    {
        // 1. Suppression de la contrainte FK
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_AVIS_VALIDEUR');

        // 2. Suppression de l’index
        $this->addSql('DROP INDEX IDX_AVIS_VALIDEUR_ID ON avis');

        // 3. Suppression de la colonne validateur_id
        $this->addSql('ALTER TABLE avis DROP COLUMN validateur_id');
    }
}
