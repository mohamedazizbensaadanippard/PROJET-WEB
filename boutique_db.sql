
DROP TABLE IF EXISTS ligne_commande;
DROP TABLE IF EXISTS commandes;
DROP TABLE IF EXISTS produits;

CREATE TABLE produits (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(120) NOT NULL,
    marque VARCHAR(80),
    categorie VARCHAR(80),
    description TEXT,
    prix NUMERIC(10,2) NOT NULL CHECK (prix >= 0),
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0),
    image VARCHAR(500)
);

CREATE TABLE commandes (
    id SERIAL PRIMARY KEY,
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
    quantite INT NOT NULL CHECK (quantite > 0),
    prix_unitaire NUMERIC(10,2) NOT NULL
);

INSERT INTO produits (nom, marque, categorie, description, prix, stock, image) VALUES
('Logitech G502 HERO', 'Logitech', 'Souris gaming', 'Souris gaming filaire avec capteur précis et boutons programmables.', 179.90, 12, 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?auto=format&fit=crop&w=900&q=80'),
('Razer DeathAdder Essential', 'Razer', 'Souris gaming', 'Souris ergonomique légère pour FPS et utilisation quotidienne.', 119.90, 9, 'https://images.unsplash.com/photo-1615663245857-ac93bb7c39e7?auto=format&fit=crop&w=900&q=80'),
('SteelSeries Rival 3', 'SteelSeries', 'Souris gaming', 'Souris RGB simple, rapide et confortable pour les jeux compétitifs.', 99.00, 14, 'https://images.unsplash.com/photo-1613141412501-9012977f1969?auto=format&fit=crop&w=900&q=80'),
('Redragon K552 Kumara', 'Redragon', 'Clavier mécanique', 'Clavier mécanique compact avec switches tactiles et éclairage RGB.', 145.00, 8, 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=900&q=80'),
('HyperX Alloy Origins Core', 'HyperX', 'Clavier mécanique', 'Clavier TKL robuste avec rétroéclairage RGB et structure aluminium.', 249.00, 6, 'https://images.unsplash.com/photo-1595225476474-87563907a212?auto=format&fit=crop&w=900&q=80'),
('Logitech K380 Bluetooth', 'Logitech', 'Clavier sans fil', 'Clavier Bluetooth compact pour PC, tablette et téléphone.', 139.00, 11, 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?auto=format&fit=crop&w=900&q=80'),
('HyperX Cloud II', 'HyperX', 'Casque gaming', 'Casque gaming avec micro détachable et son surround virtuel.', 279.00, 7, 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=900&q=80'),
('Logitech G Pro X Headset', 'Logitech', 'Casque gaming', 'Casque professionnel confortable avec micro clair pour Discord.', 349.00, 5, 'https://images.unsplash.com/photo-1546435770-a3e426bf472b?auto=format&fit=crop&w=900&q=80'),
('JBL Tune 510BT', 'JBL', 'Casque Bluetooth', 'Casque sans fil pliable avec bonne autonomie pour musique et appels.', 169.00, 13, 'https://images.unsplash.com/photo-1484704849700-f032a568e944?auto=format&fit=crop&w=900&q=80'),
('ASUS TUF Gaming VG249Q', 'ASUS', 'Ecran gaming', 'Ecran 24 pouces Full HD 144Hz pour gaming fluide.', 699.00, 4, 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?auto=format&fit=crop&w=900&q=80'),
('Samsung Odyssey G3', 'Samsung', 'Ecran gaming', 'Ecran gaming 24 pouces avec taux de rafraîchissement rapide.', 649.00, 5, 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?auto=format&fit=crop&w=900&q=80'),
('Dell P2419H', 'Dell', 'Ecran bureautique', 'Ecran 24 pouces confortable pour étude, bureautique et coding.', 520.00, 6, 'https://images.unsplash.com/photo-1585792180666-f7347c490ee2?auto=format&fit=crop&w=900&q=80'),
('Logitech C920 HD Pro', 'Logitech', 'Webcam', 'Webcam Full HD 1080p idéale pour cours en ligne et réunions.', 259.00, 10, 'https://images.unsplash.com/photo-1587614382346-4ec70e388b28?auto=format&fit=crop&w=900&q=80'),
('Samsung 970 EVO Plus 500GB', 'Samsung', 'SSD NVMe', 'SSD NVMe rapide pour accélérer Windows, logiciels et jeux.', 189.00, 15, 'https://images.unsplash.com/photo-1597852074816-d933c7d2b988?auto=format&fit=crop&w=900&q=80'),
('Kingston A400 480GB', 'Kingston', 'SSD SATA', 'SSD SATA fiable pour améliorer un PC portable ou desktop.', 129.00, 18, 'https://images.unsplash.com/photo-1591488320449-011701bb6704?auto=format&fit=crop&w=900&q=80'),
('TP-Link Archer T3U', 'TP-Link', 'Adaptateur WiFi', 'Adaptateur USB WiFi AC compact pour PC fixe ou laptop.', 69.00, 20, 'https://images.unsplash.com/photo-1606904825846-647eb07f5be2?auto=format&fit=crop&w=900&q=80'),
('Manette Xbox Wireless', 'Microsoft', 'Manette', 'Manette sans fil compatible PC pour FIFA, racing et jeux Steam.', 249.00, 9, 'https://images.unsplash.com/photo-1600080972464-8e5f35f63d08?auto=format&fit=crop&w=900&q=80'),
('PlayStation DualSense', 'Sony', 'Manette', 'Manette PS5 DualSense utilisable sur PC avec USB ou Bluetooth.', 299.00, 7, 'https://images.unsplash.com/photo-1606813907291-d86efa9b94db?auto=format&fit=crop&w=900&q=80'),
('Tapis Razer Goliathus', 'Razer', 'Accessoire', 'Grand tapis de souris pour setup gaming propre et précis.', 59.00, 25, 'https://images.unsplash.com/photo-1616588589676-62b3bd4ff6d2?auto=format&fit=crop&w=900&q=80'),
('Support PC Portable Aluminium', 'Generic', 'Accessoire', 'Support élégant pour améliorer la posture et le refroidissement.', 79.00, 16, 'https://images.unsplash.com/photo-1618384887929-16ec33fab9ef?auto=format&fit=crop&w=900&q=80');
