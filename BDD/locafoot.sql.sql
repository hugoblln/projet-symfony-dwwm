DROP DATABASE IF EXISTS locafoot;
CREATE DATABASE locafoot;
USE  locafoot;

#etape 1 : creation des tables de la bdd

#table utilisateurs
CREATE TABLE utilisateurs (
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(50) NOT NULL,
prenom VARCHAR(50) NOT NULL,
email VARCHAR(100) NOT NULL,
mot_de_passe VARCHAR(300) NOT NULL
);

#table villes
CREATE TABLE villes(
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(50) NOT NULL
);

#table statuts
CREATE TABLE statuts(
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(50) NOT NULL
);

#table horaires 
CREATE TABLE horaires (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    heure_ouverture TIME,
    heure_fermeture TIME
);

#table tarifs
CREATE TABLE tarifs (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    tarif DECIMAL(10, 2) NOT NULL
);

#table complexes
CREATE TABLE complexes(
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
nom VARCHAR(100) NOT NULL,
adresse VARCHAR(200) NOT NULL,
descr TEXT NOT NULL,
id_ville INT UNSIGNED NOT NULL,
telephone VARCHAR(10),
id_horaire INT UNSIGNED NOT NULL
);

#table terrains
CREATE TABLE terrains (
    id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    descr TEXT NOT NULL,
    type_terrain VARCHAR(100),
    taille DECIMAL(10, 2), 
    id_complexe INT UNSIGNED NOT NULL,
    id_tarif INT UNSIGNED NOT NULL
);

#table reservations
CREATE TABLE reservations (
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
id_terrain INT UNSIGNED NOT NULL,
id_utilisateur INT UNSIGNED NOT NULL,
date_debut DATETIME NOT NULL,
id_statut INT UNSIGNED NOT NULL
);

#table avis
CREATE TABLE avis (
id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
id_utilisateur INT UNSIGNED NOT NULL,
id_terrain INT UNSIGNED NOT NULL,
note TINYINT UNSIGNED NOT NULL,
commentaire TEXT NOT NULL,
date_creation DATE NOT NULL
);


#creation des relations entre les tables et des checking

#table complexe 
ALTER TABLE complexes
ADD CONSTRAINT FK_complexesidville_villesid FOREIGN KEY (id_ville) REFERENCES villes(id);

ALTER TABLE complexes
ADD CONSTRAINT FK_complexesidhoraire_horairesid FOREIGN KEY (id_horaire) REFERENCES horaires(id);

#table terrains
ALTER TABLE terrains
ADD CONSTRAINT FK_terrainsidcomplexe_complexesid FOREIGN KEY (id_complexe) REFERENCES complexes(id);

ALTER TABLE terrains
ADD CONSTRAINT FK_terrainsidtarif_tarifsid FOREIGN KEY (id_tarif) REFERENCES tarifs(id);

#table reservations 
ALTER TABLE reservations
ADD CONSTRAINT FK_reservationsidterrain_terrainsid FOREIGN KEY (id_terrain) REFERENCES terrains(id);

ALTER TABLE reservations
ADD CONSTRAINT FK_reservationsidutilisateur_utilisateursid FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id);

ALTER TABLE reservations 
ADD CONSTRAINT FK_reservationsidstatut_statutsid FOREIGN KEY (id_statut) REFERENCES statuts(id);

#table avis 
ALTER TABLE avis
ADD CONSTRAINT FK_avisidutilisateur_utilisateursid FOREIGN KEY (id_utilisateur) REFERENCES utilisateurs(id);

ALTER TABLE avis 
ADD CONSTRAINT FK_avisidterrain_terrainsid FOREIGN KEY (id_terrain) REFERENCES terrains(id); 

ALTER TABLE avis
ADD CONSTRAINT check_note CHECK (note >= 0 AND note <= 5);

