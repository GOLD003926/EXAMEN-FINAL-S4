-- =========================================
-- Ajout colonne manquante (si tu valides ce choix)
-- =========================================
ALTER TABLE comptes ADD COLUMN solde REAL DEFAULT 0;

-- =========================================
-- Préfixes
-- =========================================
INSERT INTO prefixe (id, codes, descriptions) VALUES
(1, '033', 'Telma'),
(2, '037', 'Orange');

-- =========================================
-- Types d'opérations
-- =========================================
INSERT INTO type_operations (id, codes, libelle, descriptions) VALUES
(1, 'DEP', 'Dépôt', 'Dépôt d''argent'),
(2, 'RET', 'Retrait', 'Retrait d''argent'),
(3, 'TRF', 'Transfert', 'Transfert d''argent');

-- =========================================
-- États de compte
-- =========================================
INSERT INTO etat_compte (id, codes, libelle, descriptions) VALUES
(1, 'ACTIF', 'Actif', 'Compte actif'),
(2, 'BLOQUE', 'Bloqué', 'Compte bloqué'),
(3, 'SUSPENDU', 'Suspendu', 'Compte suspendu');

-- =========================================
-- Frais d'opérations (retrait id=2, transfert id=3)
-- =========================================
INSERT INTO frais_operations (id, id_type_operation, somme_min, somme_max, frais, descriptions) VALUES
(1, 2, 100, 1000, 50, 'Frais retrait 100-1000 Ar'),
(2, 2, 1001, 5000, 50, 'Frais retrait 1001-5000 Ar'),
(3, 2, 5001, 10000, 100, 'Frais retrait 5001-10000 Ar'),
(4, 2, 10001, 25000, 200, 'Frais retrait 10001-25000 Ar'),
(5, 2, 25001, 50000, 400, 'Frais retrait 25001-50000 Ar'),
(6, 2, 50001, 100000, 800, 'Frais retrait 50001-100000 Ar'),
(7, 2, 100001, 250000, 1500, 'Frais retrait 100001-250000 Ar'),
(8, 2, 250001, 500000, 1500, 'Frais retrait 250001-500000 Ar'),
(9, 2, 500001, 1000000, 2500, 'Frais retrait 500001-1000000 Ar'),
(10, 2, 1000001, 2000000, 3000, 'Frais retrait 1000001-2000000 Ar'),
(11, 3, 100, 1000, 50, 'Frais transfert 100-1000 Ar'),
(12, 3, 1001, 5000, 50, 'Frais transfert 1001-5000 Ar'),
(13, 3, 5001, 10000, 100, 'Frais transfert 5001-10000 Ar'),
(14, 3, 10001, 25000, 200, 'Frais transfert 10001-25000 Ar'),
(15, 3, 25001, 50000, 400, 'Frais transfert 25001-50000 Ar'),
(16, 3, 50001, 100000, 800, 'Frais transfert 50001-100000 Ar'),
(17, 3, 100001, 250000, 1500, 'Frais transfert 100001-250000 Ar'),
(18, 3, 250001, 500000, 1500, 'Frais transfert 250001-500000 Ar'),
(19, 3, 500001, 1000000, 2500, 'Frais transfert 500001-1000000 Ar'),
(20, 3, 1000001, 2000000, 3000, 'Frais transfert 1000001-2000000 Ar');

-- =========================================
-- Comptes clients
-- =========================================
INSERT INTO comptes (id, numero, nom, prenom, id_etat, solde, update_at) VALUES
(1, '0331234567', 'Rakoto', 'Jean', 1, 500000, '2024-01-15'),
(2, '0377654321', 'Rasoa', 'Marie', 1, 750000, '2024-01-16'),
(3, '0339876543', 'Randria', 'Paul', 1, 250000, '2024-01-17'),
(4, '0371234567', 'Andriamanitra', 'Lucie', 2, 100000, '2024-01-18'),
(5, '0334567890', 'Rabe', 'Pierre', 1, 1500000, '2024-01-19');

-- =========================================
-- Transactions
-- =========================================
INSERT INTO transactions (id, id_compte, id_type_operation, numero_source, numero_destinataire, somme, gain, created_at) VALUES
(1, 1, 1, '0331234567', NULL, 100000, 0, '2024-01-15 10:30:00'),
(2, 1, 2, '0331234567', NULL, 50000, 400, '2024-01-15 14:20:00'),
(3, 1, 3, '0331234567', '0377654321', 75000, 400, '2024-01-16 09:15:00'),
(4, 2, 1, '0377654321', NULL, 200000, 0, '2024-01-16 11:00:00'),
(5, 2, 3, '0377654321', '0339876543', 150000, 800, '2024-01-17 16:45:00');

INSERT INTO users_operateurs (id, username, password, nom, prenom, role) VALUES
(1, 'admin', 'admin123', 'Admin', 'Principal', 'admin');

-- =========================================
-- 1. Table operateurs
-- =========================================
DROP TABLE IF EXISTS operateurs;

CREATE TABLE operateurs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    code TEXT NOT NULL,
    est_interne INTEGER DEFAULT 0,
    taux_commission REAL DEFAULT 0,
    descriptions TEXT
);

INSERT INTO operateurs (id, nom, code, est_interne, taux_commission, descriptions) VALUES
(1, 'Yas', 'YAS', 1, 0, 'Notre propre opérateur'),
(2, 'Orange', 'ORANGE', 0, 2.5, 'Opérateur externe - Orange'),
(3, 'Airtel', 'AIRTEL', 0, 3, 'Opérateur externe - Airtel');

-- =========================================
-- 2. Recréation table prefixe (droppée)
-- =========================================
DROP TABLE IF EXISTS prefixe;

CREATE TABLE prefixe (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codes TEXT NOT NULL,
    descriptions TEXT,
    id_operateur INTEGER,
    FOREIGN KEY (id_operateur) REFERENCES operateurs(id)
);

INSERT INTO prefixe (id, codes, descriptions, id_operateur) VALUES
(1, '034', 'Yas', 1),
(2, '038', 'Yas', 1),
(3, '037', 'Orange', 2),
(4, '032', 'Orange', 2),
(5, '033', 'Airtel', 3),
(6, '031', 'Airtel', 3);

-- =========================================
-- 3. ALTER TABLE transactions — nouvelles colonnes V2
-- =========================================
ALTER TABLE transactions ADD COLUMN id_operateur_destinataire INTEGER REFERENCES operateurs(id);
ALTER TABLE transactions ADD COLUMN commission REAL DEFAULT 0;
ALTER TABLE transactions ADD COLUMN inclure_frais_retrait INTEGER DEFAULT 0;
ALTER TABLE transactions ADD COLUMN batch_id TEXT DEFAULT NULL;