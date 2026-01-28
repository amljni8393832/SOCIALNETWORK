-- 1/ voici les table de la base de donnee

-- 2/ configures la base de donnee -->> connexion.php
-- 3/ creation de la base de donnee
CREATE DATABASE IF NOT EXISTS dbSocial;
-- creation de la table users
CREATE TABLE IF NOT EXISTS users (
    id serial PRIMARY KEY,
    nom VARCHAR(100) NOT NULL ,
    email VARCHAR(150) NOT NULL ,
    function ENUM('ADMIN','PROF','ETUD') NOT NULL,
    mdp VARCHAR(100) NOT NULL ,  
    photo VARCHAR(100),
    statu ENUM('online','offline') DEFAULT 'offline'
);
-- creation de la table amis
CREATE TABLE IF NOT EXISTS amis (
    id serial PRIMARY KEY,
    iduser1 int NOT NULL,
    iduser2 int NOT NULL ,
    date_amitie DATETIME NOT NULL 
);
-- creation de table message 
CREATE TABLE IF NOT EXISTS message(
    id serial PRIMARY KEY,
    expediteur int NOT NULL ,
    destinataire int NOT NULL ,
    objet VARCHAR(150) NOT NULL ,
    date DATETIME NOT NULL ,
    text TEXT NOT NULL 
);
-- creation de table invitation
CREATE TABLE IF NOT EXISTS message(
    id serial PRIMARY KEY ,
    expediteur INT NOT NULL ,
    destinatair INT NOT NULL ,
    date DATETIME NOT NULL,
    statut ENUM('en_attente','accepte','refuse') DEFAULT 'en_attente'  
           
);
