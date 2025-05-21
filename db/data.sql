INSERT INTO utilisateur (pseudo, email, mot_de_passe, role)
VALUES
('Laura', 'laura@mail.com', 'azerty', 'passager'),
('Luca', 'luca@mail.com', 'azerty', 'chauffeur'),
('Victoria', 'victoria@mail.com', 'azerty', 'passager'),
('Nine', 'nine@mail.com', 'azerty', 'chauffeur'),
('Admin', 'admin@mail.com', 'azerty', 'admin'),
('Raph', 'paul@mail.com', 'azerty', 'chauffeur'),
('Sophie', 'sophie@mail.com', 'azerty', 'passager'),
('Marie',  'marie@mail.com', 'azerty', 'passager'),
('Pierre', 'pierre@mail.com', 'azerty', 'chauffeur'),
('Lucie',  'lucie@mail.com', 'azerty', 'employe');


INSERT INTO preference (libelle) 
VALUES
('Non-fumeur'),
('Avec animaux'),
('Musique douce'),
('Climatisation'),
('Conversation');


INSERT INTO utilisateur_preference (utilisateur_id, preference_id) 
VALUES
(1, 1), (1, 3), 
(2, 1), (2,4),
(3,2),(3,5),
(4,1),(4,2),(4,3),
(5,1),
(6,4),(6,5),
(7,2),
(8,3),(8,5),
(9,1),(9,4),
(10,5);


INSERT INTO vehicule (utilisateur_id, immatriculation, date_premiere_immatriculation, marque, modele, couleur, places_disponibles, electrique)
VALUES
(2, 'AB-AZE-FT', '2020-01-01', 'Renault', 'Zoe', 'bleue', 4, TRUE),
(4, 'AB-345-FT', '2016-01-01', 'Peugeot', 'Expert', 'blanc', 2, FALSE),
(4,'EE-333-FF','2019-04-12','Peugeot','208','Rouge',3, FALSE),
(6,'GG-444-HH','2020-07-01','Nissan','Leaf','Vert',4, TRUE),
(6,'II-555-JJ','2017-11-30','Toyota','Yaris','Gris',4, FALSE),
(9,'KK-666-LL','2022-01-15','Tesla','Model Y','Noir',5, TRUE);


INSERT INTO trajet (chauffeur_id, vehicule_id, adresse_depart, adresse_arrivee, date_depart, date_arrivee, prix, places_restantes, statut, ecologique)
VALUES
(2, 1, 'Paris', 'Orléans', '2025-06-01 08:00:00', '2025-06-01 11:00:00', 15, 3, 'ouverte', TRUE),
(4, 2, 'Marseille', 'Buis', '2025-06-01 13:00:00', '2025-06-01 16:30:00', 12, 1, 'ouverte', FALSE),
(4,3,'Lyon','Grenoble','2025-06-03 07:45:00','2025-06-03 09:30:00', 20, 1, 'ouverte', FALSE),
(6,4,'Marseille','Aix-en-Provence','2025-06-04 10:00:00','2025-06-04 10:45:00', 10, 2, 'ouverte', TRUE),
(6,5,'Marseille','Nice','2025-06-05 06:15:00','2025-06-05 10:15:00', 40, 4, 'ouverte', FALSE),
(9,6,'Toulouse','Bordeaux','2025-06-06 08:30:00','2025-06-06 12:00:00', 35, 5, 'ouverte', TRUE),
(2,1,'Paris','Reims','2025-06-07 13:00:00','2025-06-07 15:00:00', 28, 4, 'ouverte', FALSE),
(6,4,'Aix-en-Provence','Avignon','2025-06-08 09:00:00','2025-06-08 10:30:00', 15, 3, 'ouverte', TRUE),
(4,3,'Grenoble','Chambéry','2025-06-09 14:00:00','2025-06-09 15:00:00', 18, 2, 'ouverte', FALSE),
(9,6,'Bordeaux','Nantes','2025-06-10 07:00:00','2025-06-10 11:00:00', 45, 5, 'ouverte', TRUE);

INSERT INTO reservation (trajet_id, passager_id, date_confirmation, statut, credits_utilises)
VALUES
(1, 1, '2025-05-21 11:00:00','confirme', 15),
(2, 4, '2025-05-21 11:00:00','confirme', 12),
(2,8,'2025-05-21 11:00:00','confirme',25),
(3,1,'2025-05-21 12:00:00','confirme',22),
(4,7,'2025-05-21 13:00:00','confirme',12),
(5,3,'2025-05-21 14:00:00','confirme',42),
(6,8,'2025-05-21 15:00:00','confirme',37),
(7,1,'2025-05-21 16:00:00','confirme',30),
(8,3,'2025-05-21 17:00:00','confirme',17),
(9,7,'2025-05-21 18:00:00','confirme',20);

INSERT INTO avis (reservation_id, note, commentaire, date_creation, statut_validation, employe_valideur_id)
VALUES
(1, 5, 'Super trajet !', '2025-05-22 09:30:00', 'valide', 5),
(2,4,'Bonne expérience','2025-05-22 09:30:00','valide',10),
(3,5,'Parfait !','2025-05-22 10:00:00','valide',10),
(4,3,'Correct, un peu tardif','2025-05-22 10:30:00','valide',10),
(5,4,'Chauffeur très sympa','2025-05-22 11:00:00','valide',10),
(6,2,'Voiture un peu sale','2025-05-22 11:30:00','valide',10),
(7,5,'Excellent trajet électrique','2025-05-22 12:00:00','valide',10),
(8,3,'Pas mal','2025-05-22 12:30:00','valide',10),
(9,4,'Bon rapport qualité/prix','2025-05-22 13:00:00','valide',10),
(10,5,'Je recommande !','2025-05-22 13:30:00','valide',10);

INSERT INTO suspension (utilisateur_id, admin_id, date_suspension, motif)
VALUES
(1, 5, '2025-05-20', 'Avis impolis');


INSERT INTO transaction (utilisateur_id, montant, date_transaction, type, trajet_id)
VALUES 
(3, 2, '2025-05-21 12:00:00', 'commission_plateforme', 1);