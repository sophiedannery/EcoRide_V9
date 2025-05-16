CREATE TABLE utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    pseudo VARCHAR(50) NOT NULL UNIQUE, 
    email VARCHAR(100) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    credits INT NOT NULL DEFAULT 20,
    role ENUM('passager', 'chauffeur', 'employe', 'admin') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE vehicule (
    id_vehicule INT AUTO_INCREMENT PRIMARY KEY,
    utilisateur_id INT NOT NULL,
    immatriculation VARCHAR(20) NOT NULL,
    date_premiere_immatriculation DATE NOT NULL, 
    marque VARCHAR(255) NOT NULL, 
    modele VARCHAR(255) NOT NULL,
    couleur VARCHAR(255),
    places_disponibles TINYINT UNSIGNED NOT NULL,
    electrique BOOLEAN NOT NULL DEFAULT FALSE, 
    INDEX idx_vehicule_utilisateur (utilisateur_id), 
    CONSTRAINT fk_vehicule_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE preference (
    id_preference INT AUTO_INCREMENT PRIMARY KEY, 
    libelle VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB;

CREATE TABLE utilisateur_preference (
    utilisateur_id INT NOT NULL, 
    preference_id INT NOT NULL,
    PRIMARY KEY (utilisateur_id, preference_id),
    INDEX idx_up_utilisateur (utilisateur_id),
    INDEX idx_up_preference (preference_id), 
    CONSTRAINT fk_up_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE, 
    CONSTRAINT fk_up_preference
        FOREIGN KEY (preference_id)
        REFERENCES preference(id_preference)
        ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE trajet (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    chauffeur_id INT NOT NULL, 
    vehicule_id INT NOT NULL, 
    adresse_depart VARCHAR(255) NOT NULL,
    adresse_arrivee VARCHAR(255) NOT NULL,
    date_depart DATETIME NOT NULL, 
    date_arrivee DATETIME NOT NULL,
    prix INT NOT NULL, 
    places_restantes TINYINT UNSIGNED NOT NULL, 
    statut ENUM('cree', 'demarre', 'termine', 'annule') NOT NULL DEFAULT 'cree', 
    ecologique BOOLEAN NOT NULL DEFAULT FALSE, 
    INDEX idx_trajet_chauffeur (chauffeur_id), 
    INDEX idx_trajet_vehicule (vehicule_id), 
    CONSTRAINT fk_trajet_chauffeur
        FOREIGN KEY (chauffeur_id)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE RESTRICT, 
    CONSTRAINT fk_trajet_vehicule
        FOREIGN KEY (vehicule_id)
        REFERENCES vehicule(id_vehicule)
        ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE reservation (
    id_reservation INT AUTO_INCREMENT PRIMARY KEY,
    trajet_id INT NOT NULL, 
    passager_id INT NOT NULL, 
    date_confirmation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    statut ENUM('confirme', 'annule') NOT NULL DEFAULT 'confirme', 
    credits_utilises INT NOT NULL, 
    INDEX idx_reservation_trajet (trajet_id), 
    INDEX idx_reservation_passager(passager_id),
    CONSTRAINT fk_reservation_trajet
        FOREIGN KEY (trajet_id)
        REFERENCES trajet(id_trajet)
        ON DELETE CASCADE, 
    CONSTRAINT fk_reservation_passager
        FOREIGN KEY (passager_id)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE RESTRICT
)ENGINE=InnoDB;

CREATE TABLE avis (
    id_avis INT AUTO_INCREMENT PRIMARY KEY, 
    reservation_id INT NOT NULL UNIQUE, 
    note TINYINT UNSIGNED NOT NULL CHECK (note BETWEEN 1 and 5), 
    commentaire TEXT, 
    date_creation DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    statut_validation ENUM('en_attente', 'valide', 'refuse') NOT NULL DEFAULT 'en_attente', 
    employe_valideur_id INT, 
    INDEX idx_avis_reservation (reservation_id),
    INDEX idx_avis_valideur (employe_valideur_id),
    CONSTRAINT fk_avis_reservation
        FOREIGN KEY (reservation_id) 
        REFERENCES reservation(id_reservation)
        ON DELETE CASCADE, 
    CONSTRAINT fk_avis_valideur
        FOREIGN KEY (employe_valideur_id) 
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE SET NULL        
) ENGINE=InnoDB;

CREATE TABLE suspension (
    id_suspension INT AUTO_INCREMENT PRIMARY KEY, 
    utilisateur_id INT NOT NULL, 
    admin_id INT NOT NULL, 
    date_suspension DATE NOT NULL, 
    motif VARCHAR(255), 
    INDEX idx_suspension_utilisateur (utilisateur_id),
    INDEX idx_suspension_admin (admin_id),
    CONSTRAINT fk_suspension_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE, 
    CONSTRAINT fk_suspension_admin
        FOREIGN KEY (admin_id)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE transaction (
    id_transaction INT AUTO_INCREMENT PRIMARY KEY, 
    utilisateur_id INT NOT NULL, 
    trajet_id INT, 
    montant INT NOT NULL, 
    date_transaction DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    type ENUM('utilisation_passager', 'credit_chauffeur', 'commission_plateforme') NOT NULL, 
    INDEX idx_transaction_utilisateur (utilisateur_id),
    INDEX idx_transaction_trajet (trajet_id),
    CONSTRAINT fk_transaction_utilisateur
        FOREIGN KEY (utilisateur_id)
        REFERENCES utilisateur(id_utilisateur)
        ON DELETE CASCADE,
    CONSTRAINT fk_transaction_trajet
        FOREIGN KEY (trajet_id)
        REFERENCES trajet(id_trajet)
        ON DELETE SET NULL
) ENGINE=InnoDB;