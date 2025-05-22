<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522151602 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Création de la table de jointure between User and Preference
        $this->addSql(<<<'SQL'
        CREATE TABLE user_preference (
            user_id INT NOT NULL,
            preference_id INT NOT NULL,
            INDEX IDX_USER_PREF_USER_ID (user_id),
            INDEX IDX_USER_PREF_PREF_ID (preference_id),
            PRIMARY KEY(user_id, preference_id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
    SQL);

        // Clés étrangères
        $this->addSql(<<<'SQL'
        ALTER TABLE user_preference
        ADD CONSTRAINT FK_USER_PREF_USER
            FOREIGN KEY (user_id)
            REFERENCES `user` (id)
            ON DELETE CASCADE
    SQL);

        $this->addSql(<<<'SQL'
        ALTER TABLE user_preference
        ADD CONSTRAINT FK_USER_PREF_PREF
            FOREIGN KEY (preference_id)
            REFERENCES preference (id)
            ON DELETE CASCADE
    SQL);
    }

    public function down(Schema $schema): void
    {
        // Suppression des contraintes FK (ordre inverse de l’up)
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_USER_PREF_PREF');
        $this->addSql('ALTER TABLE user_preference DROP FOREIGN KEY FK_USER_PREF_USER');

        // Suppression de la table
        $this->addSql('DROP TABLE user_preference');
    }
}
