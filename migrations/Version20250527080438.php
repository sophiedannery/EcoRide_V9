<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250527080438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // 1. Ajout de la colonne user_id (nullable tant que tu n'as pas de valeur à remplir)
        $this->addSql('ALTER TABLE vehicule ADD COLUMN user_id INT DEFAULT NULL');

        // 2. Création de l’index sur user_id
        $this->addSql('CREATE INDEX IDX_VEHICULE_USER_ID ON vehicule (user_id)');

        // 3. Ajout de la contrainte FK vers user(id)
        $this->addSql(<<<'SQL'
        ALTER TABLE vehicule
        ADD CONSTRAINT FK_VEHICULE_USER
            FOREIGN KEY (user_id)
            REFERENCES `user` (id)
            ON DELETE CASCADE
    SQL);
    }

    public function down(Schema $schema): void
    {
        // 1. Suppression de la FK
        $this->addSql('ALTER TABLE vehicule DROP FOREIGN KEY FK_VEHICULE_USER');

        // 2. Suppression de l’index
        $this->addSql('DROP INDEX IDX_VEHICULE_USER_ID ON vehicule');

        // 3. Suppression de la colonne user_id
        $this->addSql('ALTER TABLE vehicule DROP COLUMN user_id');
    }
}
