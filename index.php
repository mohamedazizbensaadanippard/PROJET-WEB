<?php
session_start();
require_once 'connexion.php';

$rech = trim($_GET['recherche'] ?? '');
$cat = trim($_GET['categorie'] ?? '');

$condition = [];
$valeurs = [];

if ($rech != '') {
    $condition[] = "(nom ILIKE :rech OR marque ILIKE :rech OR description ILIKE :rech)";
    $valeurs['rech'] = '%' . $rech . '%';
}

if ($cat != '') {
    $condition[] = "categorie = :cat";
    $valeurs['cat'] = $cat;
}

$sql = "SELECT * FROM produits";
if (count($condition) > 0) {
    $sql .= " WHERE " . implode(" AND ", $condition);
}
$sql .= " ORDER BY id";

$req = $pdo->prepare($sql);
$req->execute($valeurs);
$produits = $req->fetchAll();

$req2 = $pdo->query("SELECT DISTINCT categorie FROM produits ORDER BY categorie");
$categories = $req2->fetchAll(PDO::FETCH_COLUMN);

$nb = 0;
if (isset($_SESSION['panier'])) {
    $nb = array_sum($_SESSION['panier']);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GearHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="menu">
    <a href="index.php" class="marque-site">
        <div class="logo-box">GH</div>
        <div>
            <h2>GearHub</h2>
            <p>Gaming & accessoires</p>
        </div>
    </a>
    <nav>
        <a href="index.php" class="active">Accueil</a>
        <a href="panier.php">Panier <span><?= $nb ?></span></a>
    </nav>
</header>

<main class="page">
    <section class="hero">
        <div class="hero-text">
            <p class="mini-title">Boutique informatique</p>
            <h1>Bienvenue sur GearHub</h1>
            <p class="intro">Choisissez vos accessoires gaming et informatique, puis ajoutez-les facilement au panier.</p>
            <div class="buttons">
                <a href="#produits" class="btn">Voir les produits</a>
                <a href="panier.php" class="btn btn2">Mon panier</a>
            </div>
        </div>

        <form class="recherche" method="get">
            <h3>Rechercher</h3>
            <input type="text" name="recherche" placeholder="Ex : Logitech, casque..." value="<?= htmlspecialchars($rech) ?>">
            <select name="categorie">
                <option value="">Toutes les catégories</option>
                <?php foreach ($categories as $c): ?>
                    <option value="<?= htmlspecialchars($c) ?>" <?= ($cat == $c) ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit">Chercher</button>
        </form>
    </section>

    <section id="produits" class="titre-section">
        <div>
            <p class="mini-title">Catalogue</p>
            <h2>Nos produits</h2>
        </div>
        <p><?= count($produits) ?> produit(s)</p>
    </section>

    <section class="grille">
        <?php foreach ($produits as $p):
            $stock = (int)$p['stock'];
        ?>
            <div class="carte">
                <div class="photo">
                    <img src="<?= htmlspecialchars($p['image']) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                    <span><?= htmlspecialchars($p['categorie']) ?></span>
                </div>
                <div class="infos">
                    <div class="ligne-titre">
                        <h3><?= htmlspecialchars($p['nom']) ?></h3>
                        <small class="etat <?= $stock > 0 ? 'ok' : 'non' ?>">
                            <?= $stock > 0 ? $stock . ' dispo' : 'Indispo' ?>
                        </small>
                    </div>
                    <p class="marque-produit"><?= htmlspecialchars($p['marque']) ?></p>
                    <p class="desc"><?= htmlspecialchars($p['description']) ?></p>
                    <div class="bas-carte">
                        <strong><?= number_format((float)$p['prix'], 2) ?> TND</strong>
                        <?php if ($stock > 0): ?>
                            <a href="panier_action.php?action=ajouter&id=<?= $p['id'] ?>" class="btn petit">Ajouter</a>
                        <?php else: ?>
                            <span class="btn petit off">Indispo</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<footer>GearHub © 2026</footer>

</body>
</html>
