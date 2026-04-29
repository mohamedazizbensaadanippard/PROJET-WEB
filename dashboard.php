<?php
require_once 'auth.php';
obligerAdmin();
require_once 'connexion.php';

$nbProduits = $pdo->query("SELECT COUNT(*) FROM produits")->fetchColumn();
$nbCommandes = $pdo->query("SELECT COUNT(*) FROM commandes")->fetchColumn();
$nbClients = $pdo->query("SELECT COUNT(*) FROM users WHERE role='client'")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Dashboard - GearHub</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'header.php'; ?>
<main class="page">
    <section class="haut-page"><div><p class="mini-title">Admin</p><h1>Dashboard</h1></div></section>
    <section class="grille">
        <div class="bloc"><h2>Produits</h2><p class="intro"><?= $nbProduits ?> produit(s)</p><a class="btn" href="admin_produits.php">Gérer</a></div>
        <div class="bloc"><h2>Commandes</h2><p class="intro"><?= $nbCommandes ?> commande(s)</p><a class="btn" href="admin_commandes.php">Voir</a></div>
        <div class="bloc"><h2>Clients</h2><p class="intro"><?= $nbClients ?> client(s)</p></div>
    </section>
</main>
<?php include 'footer.php'; ?>
</body></html>
