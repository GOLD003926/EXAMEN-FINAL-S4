-- Script de création de la base de données Mobile Money
-- Système de simulation d'opérateur de mobile money
-- Juillet 2026 - S4 Info et Design

-- Suppression des tables existantes (si nécessaire)
DROP TABLE IF EXISTS transactions;
DROP TABLE IF EXISTS frais_operations;
DROP TABLE IF EXISTS type_operations;
DROP TABLE IF EXISTS comptes;
DROP TABLE IF EXISTS etat_compte;
DROP TABLE IF EXISTS prefixe;
DROP TABLE IF EXISTS operateurs;
DROP TABLE IF EXISTS users_operateur;

-- Table des états de compte
CREATE TABLE etat_compte (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codes TEXT NOT NULL UNIQUE,
    libelle TEXT NOT NULL,
    descriptions TEXT
);

-- Table des opérateurs (internes et externes)
CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    code TEXT NOT NULL UNIQUE,
    est_interne INTEGER NOT NULL DEFAULT 0,
    taux_commission REAL DEFAULT 0,
    descriptions TEXT
);

-- Table des préfixes téléphoniques
CREATE TABLE prefixe (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codes TEXT NOT NULL UNIQUE,
    descriptions TEXT,
    id_operateur INTEGER NOT NULL,
    FOREIGN KEY (id_operateur) REFERENCES operateurs(id)
);

-- Table des types d'opérations
CREATE TABLE type_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codes TEXT NOT NULL UNIQUE,
    libelle TEXT NOT NULL,
    descriptions TEXT
);

-- Table des barèmes de frais par tranche
CREATE TABLE frais_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER NOT NULL,
    somme_min REAL NOT NULL,
    somme_max REAL NOT NULL,
    frais REAL NOT NULL,
    descriptions TEXT,
    FOREIGN KEY (id_type_operation) REFERENCES type_operations(id)
);

-- Table des comptes clients
CREATE TABLE comptes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero TEXT NOT NULL UNIQUE,
    nom TEXT,
    prenom TEXT,
    id_etat INTEGER NOT NULL DEFAULT 1,
    solde REAL DEFAULT 0,
    update_at TEXT,
    FOREIGN KEY (id_etat) REFERENCES etat_compte(id)
);

-- Table des transactions
CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_compte INTEGER NOT NULL,
    id_type_operation INTEGER NOT NULL,
    numero_source TEXT NOT NULL,
    numero_destinataire TEXT,
    somme REAL NOT NULL,
    gain REAL DEFAULT 0,
    commission REAL DEFAULT 0,
    id_operateur_destinataire INTEGER,
    inclure_frais_retrait INTEGER DEFAULT 0,
    batch_id TEXT,
    created_at TEXT,
    FOREIGN KEY (id_compte) REFERENCES comptes(id),
    FOREIGN KEY (id_type_operation) REFERENCES type_operations(id),
    FOREIGN KEY (id_operateur_destinataire) REFERENCES operateurs(id)
);

-- Table des utilisateurs admin (accès opérateur)
CREATE TABLE users_operateur (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    nom TEXT,
    prenom TEXT,
    role TEXT DEFAULT 'admin'
);

-- Insertion des données initiales

-- États de compte
INSERT INTO etat_compte (codes, libelle, descriptions) VALUES 
('ACTIF', 'Actif', 'Compte actif et fonctionnel'),
('BLOQUE', 'Bloqué', 'Compte bloqué temporairement'),
('SUSPENDU', 'Suspendu', 'Compte suspendu définitivement');

-- Opérateur principal (interne)
INSERT INTO operateurs (nom, code, est_interne, taux_commission, descriptions) VALUES 
('Mobile Money', 'MOMO', 1, 0, 'Opérateur principal');

-- Opérateurs externes (exemple)
INSERT INTO operateurs (nom, code, est_interne, taux_commission, descriptions) VALUES 
('Telma', 'TEL', 0, 2.5, 'Opérateur Telma'),
('Orange', 'ORA', 0, 3.0, 'Opérateur Orange'),
('Airtel', 'AIR', 0, 2.0, 'Opérateur Airtel');

-- Préfixes de l'opérateur principal (033 et 037)
INSERT INTO prefixe (codes, descriptions, id_operateur) VALUES 
('033', 'Préfixe Telma', 2),
('037', 'Préfixe Telma', 2);

-- Préfixes des autres opérateurs
INSERT INTO prefixe (codes, descriptions, id_operateur) VALUES 
('032', 'Préfixe Orange', 3),
('034', 'Préfixe Orange', 3),
('038', 'Préfixe Airtel', 4);

-- Types d'opérations
INSERT INTO type_operations (codes, libelle, descriptions) VALUES 
('DEPOT', 'Dépôt', 'Dépôt d argent sur un compte'),
('RETRAIT', 'Retrait', 'Retrait d argent d un compte'),
('TRANSFERT', 'Transfert', 'Transfert d argent entre comptes');

-- Barèmes de frais par tranche (exemple)
-- Frais de dépôt (gratuit)
INSERT INTO frais_operations (id_type_operation, somme_min, somme_max, frais, descriptions) VALUES 
(1, 0, 999999999, 0, 'Dépôt gratuit');

-- Frais de retrait par tranche
INSERT INTO frais_operations (id_type_operation, somme_min, somme_max, frais, descriptions) VALUES 
(2, 0, 10000, 200, 'Frais retrait 0-10000 Ar'),
(2, 10001, 50000, 500, 'Frais retrait 10001-50000 Ar'),
(2, 50001, 100000, 1000, 'Frais retrait 50001-100000 Ar'),
(2, 100001, 999999999, 2000, 'Frais retrait >100000 Ar');

-- Frais de transfert par tranche
INSERT INTO frais_operations (id_type_operation, somme_min, somme_max, frais, descriptions) VALUES 
(3, 0, 10000, 100, 'Frais transfert 0-10000 Ar'),
(3, 10001, 50000, 300, 'Frais transfert 10001-50000 Ar'),
(3, 50001, 100000, 500, 'Frais transfert 50001-100000 Ar'),
(3, 100001, 999999999, 1000, 'Frais transfert >100000 Ar');

-- Utilisateur admin par défaut (mot de passe: admin123)
-- Note: Le mot de passe doit être hashé en production
INSERT INTO users_operateur (username, password, nom, prenom, role) VALUES 
('admin', 'admin123', 'Administrateur', 'Système', 'admin');

-- Index pour optimiser les requêtes
CREATE INDEX idx_transactions_compte ON transactions(id_compte);
CREATE INDEX idx_transactions_type ON transactions(id_type_operation);
CREATE INDEX idx_transactions_source ON transactions(numero_source);
CREATE INDEX idx_transactions_destinataire ON transactions(numero_destinataire);
CREATE INDEX idx_transactions_date ON transactions(created_at);
CREATE INDEX idx_transactions_batch ON transactions(batch_id);
CREATE INDEX idx_comptes_numero ON comptes(numero);
CREATE INDEX idx_comptes_etat ON comptes(id_etat);
CREATE INDEX idx_prefixe_codes ON prefixe(codes);
CREATE INDEX idx_prefixe_operateur ON prefixe(id_operateur);
