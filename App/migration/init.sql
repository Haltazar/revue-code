-- Table des utilisateurs
CREATE TABLE utilisateurs
(
    id               INT AUTO_INCREMENT PRIMARY KEY,
    nom              VARCHAR(50)         NOT NULL,
    email            VARCHAR(100) UNIQUE NOT NULL, 
    mot_de_passe     VARCHAR(255)        NOT NULL, 
    avatar_url       VARCHAR(255),
    date_inscription DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Table des items
CREATE TABLE items
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    description TEXT, 
    type        ENUM ('arme', 'armure', 'consommable', 'cle', 'objet') DEFAULT 'objet', 
    valeur      INT                                                    DEFAULT 0 
);

-- Table des lieux
CREATE TABLE lieux
(
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nom         VARCHAR(100) NOT NULL,
    description TEXT,
    coord_x     INT,
    coord_y     INT
);

-- Table des quêtes
CREATE TABLE quetes
(
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    titre              VARCHAR(100) NOT NULL,
    description        TEXT,
    lieu_id            INT,              -- Manque contrainte FOREIGN KEY
    recompense_item_id INT              -- Idem, devrait référencer items(id)
);

-- Table des connaissances
CREATE TABLE connaissances
(
    id      INT AUTO_INCREMENT PRIMARY KEY,
    titre   VARCHAR(100) NOT NULL,
    contenu TEXT
);

-- Inventaire des joueurs (relation N:N utilisateurs <-> items)
CREATE TABLE inventaire
(
    utilisateur_id INT,
    item_id        INT,
    quantite       INT DEFAULT 1,
    PRIMARY KEY (utilisateur_id, item_id),
    -- Manque les contraintes FOREIGN KEY sur utilisateur_id et item_id
    -- quantite pourrait être contraint à >= 0 via CHECK(quantite >= 0)
);

-- Quêtes accomplies par les joueurs
CREATE TABLE utilisateur_quetes
(
    quete_id       INT,
    utilisateur_id INT,
    date_accomplie DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (quete_id, utilisateur_id),
    -- Manque FOREIGN KEY pour les deux colonnes
);

-- Connaissances acquises via les quêtes
CREATE TABLE utilisateur_connaissances
(
    utilisateur_id   INT,
    connaissance_id  INT,
    date_acquisition DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (utilisateur_id, connaissance_id),
    -- Manque FOREIGN KEY pour les deux colonnes
);
