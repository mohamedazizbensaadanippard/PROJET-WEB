<?php
session_start();
require_once 'connexion.php';

$panier = $_SESSION['panier'] ?? [];
if (empty($panier)) {
    header('Location: panier.php');
    exit;
}

$ids = array_keys($panier);
$marks = implode(',', array_fill(0, count($ids), '?'));
$req = $pdo->prepare("SELECT * FROM produits WHERE id IN ($marks)");
$req->execute($ids);
$produits = $req->fetchAll();

$total = 0;
foreach ($produits as $p) {
    $total = $total + ((float)$p['prix'] * $panier[$p['id']]);
}

$msg = '';
$ok = false;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $tel = trim($_POST['telephone'] ?? '');

    if ($nom != '' && $email != '') {
        try {
            $pdo->beginTransaction();

            $reqCmd = $pdo->prepare("INSERT INTO commandes (nom_client, email_client, telephone, total) VALUES (?, ?, ?, ?) RETURNING id");
            $reqCmd->execute([$nom, $email, $tel, $total]);
            $idCmd = $reqCmd->fetchColumn();

            $reqLigne = $pdo->prepare("INSERT INTO ligne_commande (commande_id, produit_id, quantite, prix_unitaire) VALUES (?, ?, ?, ?)");
            $reqStock = $pdo->prepare("UPDATE produits SET stock = stock - ? WHERE id = ? AND stock >= ?");

            foreach ($produits as $p) {
                $qte = $panier[$p['id']];
                $reqLigne->execute([$idCmd, $p['id'], $qte, $p['prix']]);
                $reqStock->execute([$qte, $p['id'], $qte]);
            }

            $pdo->commit();
            $_SESSION['panier'] = [];
            $ok = true;
            $msg = "Votre commande a été enregistrée. Numéro : " . $idCmd;
        } catch (Exception $e) {
            $pdo->rollBack();
            $msg = "Erreur : " . $e->getMessage();
        }
    } else {
        $msg = "Veuillez remplir le nom et l'email.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande - GearHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="menu">
    <a href="index.php" class="marque-site">
        <img src="assests/brand/gearhub-icon.svg" class="logo-box" alt="GearHub">
        <div><h2>GearHub</h2><p>Gaming & accessoires</p></div>
    </a>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="panier.php">Panier</a>
    </nav>
</header>

<main class="page">
    <section class="haut-page">
        <div>
            <p class="mini-title">Commande</p>
            <h1>Validation</h1>
        </div>
    </section>

    <?php if ($msg != ''): ?>
        <div class="message bloc <?= $ok ? 'msg-ok' : 'msg-erreur' ?>">
            <h2><?= $ok ? 'Commande confirmée' : 'Problème' ?></h2>
            <p><?= htmlspecialchars($msg) ?></p>
            <a href="index.php" class="btn">Retour à l'accueil</a>
        </div>
    <?php else: ?>
        <section class="commande-page">
            <form method="post" class="bloc form-client">
                <h2>Informations client</h2>
                <label>Nom complet</label>
                <input type="text" name="nom" required>
                <label>Email</label>
                <input type="email" name="email" required>
                <label>Téléphone</label>
                <input type="text" name="telephone" placeholder="+216 ...">
                <button type="submit" class="full">Confirmer la commande</button>
            </form>

            <aside class="resume bloc">
                <h2>Total</h2>
                <div class="total"><span>Montant</span><strong><?= number_format($total, 2) ?> TND</strong></div>
                <p>Vérifiez les informations avant de confirmer.</p>
            </aside>
        </section>
    <?php endif; ?>
</main>
<footer>GearHub © 2026</footer>
</body>
</html>
