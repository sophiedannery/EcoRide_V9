# EcoRide

Plateforme de covoiturage éco-responsable - backend Symfony

## Prérequis

- PHP > 8.2
- Composer
- Symfony CLI
- MySQL

## Installation

## Configuration de l'environnement

1. Dupliquer le fichier d'environnement par défaut :
   cp .env .env.local

2. Ouvrir .env.local et ajuster la variable DATABASE_URL

3. Charger la base de données via SQL

## Initialisation de la base de données

1. Créer la base :
   mysql -u root -p -e "CREATE DATABASE ecoride_V9 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

2. Importer le shéma
   mysql -u root -p ecoride_v9 < db/shema.sql

3. Importer les données de test
   mysql -u root -p ecoride_v9 < db/data.sql
