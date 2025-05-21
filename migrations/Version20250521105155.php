<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250521105155 extends AbstractMigration
{
    public function up(Schema $schema): void
    {

        // 2) Ajouter roles JSON (initialisé vide)
        $this->addSql(<<<'SQL'
        ALTER TABLE utilisateur 
        ADD roles JSON NOT NULL COMMENT '(DC2Type:json)'
    SQL);
    }

    public function down(Schema $schema): void
    {
        // Supprimer la colonne roles
        $this->addSql('ALTER TABLE utilisateur DROP roles');
    }
}
