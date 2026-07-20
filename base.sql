-- Active: 1784527129083@@127.0.0.1@3306
CREATE TABLE prefixe (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codes TEXT,
    descriptions TEXT
);

CREATE TABLE type_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codes TEXT,
    libelle TEXT,
    descriptions TEXT
);

CREATE TABLE frais_operations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_type_operation INTEGER,
    somme_min REAL,
    somme_max REAL,
    frais REAL,
    descriptions TEXT,
    FOREIGN KEY (id_type_operation) REFERENCES type_operations(id)
);

CREATE TABLE etat_compte (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    codes TEXT,
    libelle TEXT,
    descriptions TEXT
);

CREATE TABLE comptes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    numero TEXT,
    nom TEXT,
    prenom TEXT,
    id_etat INTEGER,
    update_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_etat) REFERENCES etat_compte(id)
);

CREATE TABLE transactions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    id_compte INTEGER,
    id_type_operation INTEGER,
    numero_source TEXT,
    numero_destinataire TEXT,
    somme REAL,
    gain REAL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_compte) REFERENCES comptes(id),
    FOREIGN KEY (id_type_operation) REFERENCES type_operations(id)
);