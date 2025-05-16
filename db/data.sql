INSERT INTO utilisateur (pseudo, email, mot_de_passe, role)
VALUES
('laura', 'laura@mail.com', 'azerty', 'passager'),
('luca', 'luca@mail.com', 'azerty', 'chauffeur'),
('victoria', 'victoria@mail.com', 'azerty', 'passager'),
('nine', 'nine@mail.com', 'azerty', 'chauffeur'),
('admin', 'admin@mail.com', 'azerty', 'admin');


INSERT INTO preference (libelle) 
VALUES
('Non-fumeur'),
('Avec animaux'),
('Musique douce');


INSERT INTO utilisateur_preference (utilisateur_id, preference_id) 
VALUES
(1, 1), 
(1, 3), 
(2, 2);


INSERT INTO vehicule (utilisateur_id, immatriculation, date_premiere_immatriculation, marque, modele, places_disponibles, electrique)
VALUES
(2, 'AB-AZE-FT', '2020-01-01', 'Renault', 'Zoe', 4, TRUE),
(4, 'AB-345-FT', '2016-01-01', 'Peugeot', 'Expert', 2, FALSE);


INSERT INTO trajet (chauffeur_id, vehicule_id, adresse_depart, adresse_arrivee, date_depart, date_arrivee, prix, places_restantes, ecologique)
VALUES
(2, 1, 'Paris', 'Orléans', '2025-06-01 08:00:00', '2025-06-01 11:00:00', 15, 3, TRUE),
(4, 2, 'Marseille', 'Buis', '2025-06-01 13:00:00', '2025-06-01 16:30:00', 12, 1, FALSE);

INSERT INTO reservation (trajet_id, passager_id, credits_utilises)
VALUES
(1, 1, 15),
(2, 4, 12);

INSERT INTO avis (reservation_id, note, commentaire, statut_validation, employe_valideur_id)
VALUES
(1, 5, 'Super trajet !', 'valide', 5);

INSERT INTO suspension (utilisateur_id, admin_id, date_suspension, motif)
VALUES
(1, 5, '2025-05-20', 'Avis impolis');


INSERT INTO transaction (utilisateur_id, trajet_id, montant, type)
VALUES 
(3, 1, 2, 'commission_plateforme');