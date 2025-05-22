<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250522143358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE avis ADD id INT AUTO_INCREMENT NOT NULL, DROP id_avis, CHANGE note note INT NOT NULL, CHANGE commentaire commentaire LONGTEXT DEFAULT NULL, CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE statut_validation statut_validation VARCHAR(255) NOT NULL, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF07D80FC6E FOREIGN KEY (employe_valideur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_avis_reservation ON avis
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8F91ABF0B83297E7 ON avis (reservation_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_avis_valideur ON avis
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_8F91ABF07D80FC6E ON avis (employe_valideur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference MODIFY id_preference INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX libelle ON preference
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON preference
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference CHANGE id_preference id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation MODIFY id_reservation INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY fk_reservation_trajet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY fk_reservation_passager
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY fk_reservation_trajet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY fk_reservation_passager
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation CHANGE date_confirmation date_confirmation DATETIME NOT NULL, CHANGE statut statut VARCHAR(255) NOT NULL, CHANGE id_reservation id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571A51189 FOREIGN KEY (passager_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_reservation_trajet ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_42C84955D12A823 ON reservation (trajet_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_reservation_passager ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_42C8495571A51189 ON reservation (passager_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT fk_reservation_trajet FOREIGN KEY (trajet_id) REFERENCES trajet (id_trajet) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT fk_reservation_passager FOREIGN KEY (passager_id) REFERENCES utilisateur (id_utilisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension MODIFY id_suspension INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension DROP FOREIGN KEY fk_suspension_admin
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension DROP FOREIGN KEY fk_suspension_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_suspension_admin ON suspension
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON suspension
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension DROP FOREIGN KEY fk_suspension_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension CHANGE id_suspension id INT AUTO_INCREMENT NOT NULL, CHANGE admin_id administrateur_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD CONSTRAINT FK_82AF0500FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD CONSTRAINT FK_82AF05007EE5403C FOREIGN KEY (administrateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_82AF05007EE5403C ON suspension (administrateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_suspension_utilisateur ON suspension
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_82AF0500FB88E14F ON suspension (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD CONSTRAINT fk_suspension_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet MODIFY id_trajet INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY fk_trajet_chauffeur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY fk_trajet_vehicule
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON trajet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY fk_trajet_chauffeur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY fk_trajet_vehicule
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet CHANGE places_restantes places_restantes INT NOT NULL, CHANGE statut statut VARCHAR(255) NOT NULL, CHANGE ecologique ecologique TINYINT(1) NOT NULL, CHANGE id_trajet id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C85C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_trajet_chauffeur ON trajet
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2B5BA98C85C0B3BE ON trajet (chauffeur_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_trajet_vehicule ON trajet
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_2B5BA98C4A4A3511 ON trajet (vehicule_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT fk_trajet_chauffeur FOREIGN KEY (chauffeur_id) REFERENCES utilisateur (id_utilisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT fk_trajet_vehicule FOREIGN KEY (vehicule_id) REFERENCES vehicule (id_vehicule)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction MODIFY id_transaction INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY fk_transaction_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY fk_transaction_trajet
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON transaction
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY fk_transaction_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY fk_transaction_trajet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction CHANGE date_transaction date_transaction DATETIME NOT NULL, CHANGE id_transaction id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT FK_723705D1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_transaction_utilisateur ON transaction
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_723705D1FB88E14F ON transaction (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_transaction_trajet ON transaction
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_723705D1D12A823 ON transaction (trajet_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT fk_transaction_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT fk_transaction_trajet FOREIGN KEY (trajet_id) REFERENCES trajet (id_trajet) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD pseudo VARCHAR(255) NOT NULL, ADD credits INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur MODIFY id_utilisateur INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX pseudo ON utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX email ON utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur CHANGE pseudo pseudo VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL, CHANGE date_creation date_creation DATETIME NOT NULL, CHANGE credits credits INT NOT NULL, CHANGE id_utilisateur id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule MODIFY id_vehicule INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule DROP FOREIGN KEY fk_vehicule_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON vehicule
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule DROP FOREIGN KEY fk_vehicule_utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule CHANGE immatriculation immatriculation VARCHAR(255) NOT NULL, CHANGE couleur couleur VARCHAR(255) NOT NULL, CHANGE places_disponibles places_disponibles INT NOT NULL, CHANGE electrique electrique TINYINT(1) NOT NULL, CHANGE id_vehicule id INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_vehicule_utilisateur ON vehicule
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_292FFF1DFB88E14F ON vehicule (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule ADD CONSTRAINT fk_vehicule_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE avis MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0B83297E7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF07D80FC6E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON avis
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0B83297E7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF07D80FC6E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis ADD id_avis INT NOT NULL, DROP id, CHANGE note note TINYINT(1) NOT NULL, CHANGE commentaire commentaire TEXT DEFAULT NULL, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE statut_validation statut_validation VARCHAR(255) DEFAULT 'en_attente' NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_8f91abf0b83297e7 ON avis
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_avis_reservation ON avis (reservation_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_8f91abf07d80fc6e ON avis
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_avis_valideur ON avis (employe_valideur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0B83297E7 FOREIGN KEY (reservation_id) REFERENCES reservation (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF07D80FC6E FOREIGN KEY (employe_valideur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON preference
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference CHANGE id id_preference INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX libelle ON preference (libelle)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE preference ADD PRIMARY KEY (id_preference)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D12A823
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571A51189
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955D12A823
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation DROP FOREIGN KEY FK_42C8495571A51189
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation CHANGE date_confirmation date_confirmation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE statut statut VARCHAR(255) DEFAULT 'confirme' NOT NULL, CHANGE id id_reservation INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT fk_reservation_trajet FOREIGN KEY (trajet_id) REFERENCES trajet (id_trajet) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT fk_reservation_passager FOREIGN KEY (passager_id) REFERENCES utilisateur (id_utilisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD PRIMARY KEY (id_reservation)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_42c8495571a51189 ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_reservation_passager ON reservation (passager_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_42c84955d12a823 ON reservation
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_reservation_trajet ON reservation (trajet_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C84955D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE reservation ADD CONSTRAINT FK_42C8495571A51189 FOREIGN KEY (passager_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension DROP FOREIGN KEY FK_82AF0500FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension DROP FOREIGN KEY FK_82AF05007EE5403C
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_82AF05007EE5403C ON suspension
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON suspension
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension DROP FOREIGN KEY FK_82AF0500FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension CHANGE id id_suspension INT AUTO_INCREMENT NOT NULL, CHANGE administrateur_id admin_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD CONSTRAINT fk_suspension_admin FOREIGN KEY (admin_id) REFERENCES utilisateur (id_utilisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD CONSTRAINT fk_suspension_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_suspension_admin ON suspension (admin_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD PRIMARY KEY (id_suspension)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_82af0500fb88e14f ON suspension
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_suspension_utilisateur ON suspension (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE suspension ADD CONSTRAINT FK_82AF0500FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C85C0B3BE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C4A4A3511
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON trajet
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C85C0B3BE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet DROP FOREIGN KEY FK_2B5BA98C4A4A3511
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet CHANGE places_restantes places_restantes TINYINT(1) NOT NULL, CHANGE statut statut VARCHAR(255) DEFAULT 'cree' NOT NULL, CHANGE ecologique ecologique TINYINT(1) DEFAULT 0 NOT NULL, CHANGE id id_trajet INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT fk_trajet_chauffeur FOREIGN KEY (chauffeur_id) REFERENCES utilisateur (id_utilisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT fk_trajet_vehicule FOREIGN KEY (vehicule_id) REFERENCES vehicule (id_vehicule)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD PRIMARY KEY (id_trajet)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_2b5ba98c85c0b3be ON trajet
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_trajet_chauffeur ON trajet (chauffeur_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_2b5ba98c4a4a3511 ON trajet
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_trajet_vehicule ON trajet (vehicule_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C85C0B3BE FOREIGN KEY (chauffeur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE trajet ADD CONSTRAINT FK_2B5BA98C4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D12A823
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON transaction
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1FB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction DROP FOREIGN KEY FK_723705D1D12A823
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction CHANGE date_transaction date_transaction DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE id id_transaction INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT fk_transaction_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT fk_transaction_trajet FOREIGN KEY (trajet_id) REFERENCES trajet (id_trajet) ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD PRIMARY KEY (id_transaction)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_723705d1fb88e14f ON transaction
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_transaction_utilisateur ON transaction (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_723705d1d12a823 ON transaction
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_transaction_trajet ON transaction (trajet_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT FK_723705D1FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE transaction ADD CONSTRAINT FK_723705D1D12A823 FOREIGN KEY (trajet_id) REFERENCES trajet (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP pseudo, DROP credits
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON utilisateur
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur CHANGE pseudo pseudo VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL, CHANGE date_creation date_creation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE credits credits INT DEFAULT 20 NOT NULL, CHANGE id id_utilisateur INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX pseudo ON utilisateur (pseudo)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX email ON utilisateur (email)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE utilisateur ADD PRIMARY KEY (id_utilisateur)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `PRIMARY` ON vehicule
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule DROP FOREIGN KEY FK_292FFF1DFB88E14F
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule CHANGE immatriculation immatriculation VARCHAR(20) NOT NULL, CHANGE couleur couleur VARCHAR(255) DEFAULT NULL, CHANGE places_disponibles places_disponibles TINYINT(1) NOT NULL, CHANGE electrique electrique TINYINT(1) DEFAULT 0 NOT NULL, CHANGE id id_vehicule INT AUTO_INCREMENT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule ADD CONSTRAINT fk_vehicule_utilisateur FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id_utilisateur) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule ADD PRIMARY KEY (id_vehicule)
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX idx_292fff1dfb88e14f ON vehicule
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX idx_vehicule_utilisateur ON vehicule (utilisateur_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE vehicule ADD CONSTRAINT FK_292FFF1DFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id)
        SQL);
    }
}
