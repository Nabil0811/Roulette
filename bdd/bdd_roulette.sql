-- Création de la base de données --
DROP DATABASE IF EXISTS bdd_roulette;
CREATE DATABASE bdd_roulette;
USE bdd_roulette;

-- Structure de la table 'classes'
CREATE TABLE classes (
    idC INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nomC VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contenu de la table "classes"
INSERT INTO classes (nomC) VALUES 
("SIO2"),
("SLAM2"),
("SISR2");

-- Structure de la table "eleves"
CREATE TABLE eleves (
    idE INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    prenomE VARCHAR(50) NOT NULL,
    nomE VARCHAR(50) NOT NULL,
    statutE BOOLEAN DEFAULT false,
    idC INT unsigned NOT NULL,
    nb_tirages INT UNSIGNED DEFAULT 0,
    FOREIGN KEY (idC) REFERENCES classes(idC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contenu de la table "eleves"
INSERT INTO eleves (nomE, prenomE, idC) VALUES
("Aoudache", "Karim", 1),
("Aveline", "Baptiste", 1),
("Ballot", "Alexis", 1),
("Camus", "Jordan", 1),
("Chafaï", "Yacine", 1),
("Chateau", "Clément", 1),
("Delafaite", "Nathan", 1),
("Gadroy", "Léo", 1),
("Gérard", "David", 1),
("Malherbe", "Arthur", 1),
("Mao", "Pauline", 1),
("Nouvian", "Pierre-Loup", 1),
("Oudar", "Nicolas", 1),
("Ponsin", "Flavien", 1),
("Senhadji", "Hamza", 1),
("Turquier", "Victor", 1),
("Sellier", "Luka", 1),
("Kreir", "Yanis", 1),
("Hubert", "Léa", 1),
("Guillaume", "Corentin", 1),
("De Lange", "Aymeric", 1),
("Barial", "Benjamin", 1),
("Aubriet", "Aurélien", 1),
("Vandendrich", "Bryan", 1),
("Willig", "Jules", 1),
("Wintrebert", "Mathéo", 1),
("Sellier", "Luka", 2),
("Kreir", "Yanis", 2),
("Hubert", "Léa", 2),
("Guillaume", "Corentin", 2),
("De Lange", "Aymeric", 2),
("Barial", "Benjamin", 2),
("Aubriet", "Aurélien", 2),
("Vandendrich", "Bryan", 2),
("Willig", "Jules", 2),
("Wintrebert", "Mathéo", 2),
("Aoudache", "Karim", 3),
("Aveline", "Baptiste", 3),
("Ballot", "Alexis", 3),
("Camus", "Jordan", 3),
("Chafaï", "Yacine", 3),
("Chateau", "Clément", 3),
("Delafaite", "Nathan", 3),
("Gadroy", "Léo", 3),
("Gérard", "David", 3),
("Malherbe", "Arthur", 3),
("Mao", "Pauline", 3),
("Nouvian", "Pierre-Loup", 3),
("Oudar", "Nicolas", 3),
("Ponsin", "Flavien", 3),
("Senhadji", "Hamza", 3),
("Turquier", "Victor", 3);

-- Structure de la table "abscences"
CREATE TABLE abscences (
    idA INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    dateA DATE NOT NULL,
    idE INT unsigned NOT NULL,
    FOREIGN KEY (idE) REFERENCES eleves(idE)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Structure de la table "Notes"
CREATE TABLE notes (
    idN INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    valeurN INT NOT NULL,
    idE INT unsigned NOT NULL,
    FOREIGN KEY (idE) REFERENCES eleves(idE)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Nouvelle table pour les statistiques de notes
CREATE TABLE stats_notes (
    idSN INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    idC INT UNSIGNED NOT NULL,
    moyenne FLOAT,
    mediane FLOAT,
    ecart_type FLOAT,
    meilleur_eleve VARCHAR(100),
    moins_bon_eleve VARCHAR(100),
    date_calcul DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (idC) REFERENCES classes(idC)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;