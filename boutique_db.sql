DROP TABLE IF EXISTS ligne_commande;
DROP TABLE IF EXISTS commandes;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS produits;

CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'client'
);

CREATE TABLE produits (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(120) NOT NULL,
    marque VARCHAR(80),
    categorie VARCHAR(80),
    description TEXT,
    prix NUMERIC(10,2) NOT NULL,
    stock INT NOT NULL DEFAULT 0,
    image VARCHAR(500)
);

CREATE TABLE commandes (
    id SERIAL PRIMARY KEY,
    user_id INT REFERENCES users(id),
    nom_client VARCHAR(100) NOT NULL,
    email_client VARCHAR(120) NOT NULL,
    telephone VARCHAR(30),
    total NUMERIC(10,2) NOT NULL,
    date_commande TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE ligne_commande (
    id SERIAL PRIMARY KEY,
    commande_id INT NOT NULL REFERENCES commandes(id) ON DELETE CASCADE,
    produit_id INT NOT NULL REFERENCES produits(id),
    quantite INT NOT NULL,
    prix_unitaire NUMERIC(10,2) NOT NULL
);

-- Admin account: admin@gearhub.com / admin123
INSERT INTO users (nom, email, password, role) VALUES
('Admin GearHub', 'admin@gearhub.com', 'admin123', 'admin');

INSERT INTO produits (nom, marque, categorie, description, prix, stock, image) VALUES
('Logitech G502 HERO', 'Logitech', 'Souris gaming', 'Souris gaming filaire avec capteur précis et boutons programmables.', 179.90, 50, 'assests/products/logitech-g502.svg'),
('Razer DeathAdder Essential', 'Razer', 'Souris gaming', 'Souris ergonomique légère pour FPS et utilisation quotidienne.', 119.90, 50, 'assests/products/razer-deathadder.svg'),
('SteelSeries Rival 3', 'SteelSeries', 'Souris gaming', 'Souris RGB simple, rapide et confortable pour les jeux compétitifs.', 99.00, 50, 'assests/products/steelseries-rival3.svg'),
('Redragon K552 Kumara', 'Redragon', 'Clavier mécanique', 'Clavier mécanique compact avec switches tactiles et éclairage RGB.', 145.00, 50, 'assests/products/redragon-k552.svg'),
('HyperX Alloy Origins Core', 'HyperX', 'Clavier mécanique', 'Clavier TKL robuste avec rétroéclairage RGB et structure aluminium.', 249.00, 50, 'assests/products/hyperx-alloy.svg'),
('Logitech K380 Bluetooth', 'Logitech', 'Clavier sans fil', 'Clavier Bluetooth compact pour PC, tablette et téléphone.', 139.00, 50, 'assests/products/logitech-k380.svg'),
('HyperX Cloud II', 'HyperX', 'Casque gaming', 'Casque gaming avec micro détachable et son surround virtuel.', 279.00, 50, 'assests/products/hyperx-cloud2.svg'),
('Logitech G Pro X Headset', 'Logitech', 'Casque gaming', 'Casque professionnel confortable avec micro clair pour Discord.', 349.00, 50, 'assests/products/logitech-gprox.svg'),
('JBL Tune 510BT', 'JBL', 'Casque Bluetooth', 'Casque sans fil pliable avec bonne autonomie pour musique et appels.', 169.00, 50, 'assests/products/jbl-tune.svg'),
('ASUS TUF Gaming VG249Q', 'ASUS', 'Ecran gaming', 'Ecran 24 pouces Full HD 144Hz pour gaming fluide.', 699.00, 50, 'assests/products/asus-tuf.svg'),
('Samsung Odyssey G3', 'Samsung', 'Ecran gaming', 'Ecran gaming 24 pouces avec taux de rafraîchissement rapide.', 649.00, 50, 'assests/products/samsung-odyssey.svg'),
('Dell P2419H', 'Dell', 'Ecran bureautique', 'Ecran 24 pouces confortable pour étude, bureautique et coding.', 520.00, 50, 'assests/products/dell-p2419h.svg'),
('Logitech C920 HD Pro', 'Logitech', 'Webcam', 'Webcam Full HD 1080p idéale pour cours en ligne et réunions.', 259.00, 50, 'assests/products/webcam-c920.svg'),
('Samsung 970 EVO Plus 500GB', 'Samsung', 'SSD NVMe', 'SSD NVMe rapide pour accélérer Windows, logiciels et jeux.', 189.00, 50, 'assests/products/samsung-970.svg'),
('Kingston A400 480GB', 'Kingston', 'SSD SATA', 'SSD SATA fiable pour améliorer un PC portable ou desktop.', 129.00, 50, 'assests/products/kingston-a400.svg'),
('TP-Link Archer T3U', 'TP-Link', 'Adaptateur WiFi', 'Adaptateur USB WiFi AC compact pour PC fixe ou laptop.', 69.00, 50, 'assests/products/tplink-t3u.svg'),
('Manette Xbox Wireless', 'Microsoft', 'Manette', 'Manette sans fil compatible PC pour FIFA, racing et jeux Steam.', 249.00, 50, 'assests/products/xbox-controller.svg'),
('PlayStation DualSense', 'Sony', 'Manette', 'Manette PS5 DualSense utilisable sur PC avec USB ou Bluetooth.', 299.00, 50, 'assests/products/dualsense.svg'),
('Tapis Razer Goliathus', 'Razer', 'Accessoire', 'Grand tapis de souris pour setup gaming propre et précis.', 59.00, 50, 'assests/products/razer-pad.svg'),
('Support PC Portable Aluminium', 'Generic', 'Accessoire', 'Support élégant pour améliorer la posture et le refroidissement.', 79.00, 50, 'assests/products/laptop-stand.svg');
