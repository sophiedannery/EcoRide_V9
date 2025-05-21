DROP DATABASE IF EXISTS ecorive_v9;
CREATE DATABASE ecorive_v9
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;
USE ecorive_v9;

SOURCE schema.sql;
SOURCE data.sql;