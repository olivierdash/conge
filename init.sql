-- 1. Table Départements
CREATE TABLE departements (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    description TEXT
);

-- 2. Table Types de Congé
CREATE TABLE types_conge (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    libelle TEXT NOT NULL,
    jours_annuels INTEGER,
    deductible INTEGER DEFAULT 1 -- 0/1 pour booléen
);

-- 3. Table Employés
CREATE TABLE employes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nom TEXT NOT NULL,
    prenom TEXT NOT NULL,
    email TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT,
    departement_id INTEGER,
    date_embauche DATE,
    actif INTEGER DEFAULT 1, -- 0/1 pour booléen
    FOREIGN KEY (departement_id) REFERENCES departements(id)
);

-- 4. Table Soldes (Gestion des compteurs)
CREATE TABLE soldes (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER,
    type_conge_id INTEGER,
    annee INTEGER,
    jours_attribues REAL,
    jours_pris REAL DEFAULT 0,
    FOREIGN KEY (employe_id) REFERENCES employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id)
);

-- 5. Table Congés (Demandes)
CREATE TABLE conges (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    employe_id INTEGER,
    type_conge_id INTEGER,
    date_debut DATE,
    date_fin DATE,
    nb_jours REAL,
    motif TEXT,
    statut TEXT CHECK(statut IN ('en_attente', 'approuvee', 'refusee', 'annulee')) DEFAULT 'en_attente',
    commentaire_rh TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    traite_par INTEGER,
    FOREIGN KEY (employe_id) REFERENCES employes(id),
    FOREIGN KEY (type_conge_id) REFERENCES types_conge(id),
    FOREIGN KEY (traite_par) REFERENCES employes(id)
);