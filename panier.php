<?php
session_start();
require_once 'connexion.php';

$panier = $_SESSION['panier'] ?? [];
$produits = [];
$total = 0;
$nb = array_sum($panier);

if (!empty($panier)) {
    $ids = array_keys($panier);
    $marks = implode(',', array_fill(0, count($ids), '?'));
    $req = $pdo->prepare("SELECT * FROM produits WHERE id IN ($marks)");
    $req->execute($ids);
    $produits = $req->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Panier - GearHub</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'header.php'; ?>
<main class="page">
    <section class="haut-page">
        <div><p class="mini-title">Panier</p><h1>Votre panier</h1></div>
        <a href="index.php" class="btn btn2">Continuer les achats</a>
    </section>

    <?php if (empty($produits)): ?>
        <div class="vide bloc">
            <h2>Panier vide</h2>
            <p>Vous n'avez pas encore ajouté de produits.</p>
            <a href="index.php" class="btn">Retour aux produits</a>
        </div>
    <?php else: ?>
        <section class="panier-page">
            <div class="table-box bloc">
                <table>
                    <thead><tr><th>Produit</th><th>Prix</th><th>Quantité</th><th>Total</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($produits as $p):
                        $qte = $panier[$p['id']];
                        $sousTotal = (float)$p['prix'] * $qte;
                        $total += $sousTotal;
                        $image = $p['image'] ?: 'assests/products/default.svg';
                    ?>
                        <tr>
                            <td>
                                <div class="prod-panier">
                                    <img src="<?= htmlspecialchars($image) ?>" alt="<?= htmlspecialchars($p['nom']) ?>">
                                    <div><strong><?= htmlspecialchars($p['nom']) ?></strong><p><?= htmlspecialchars($p['marque']) ?></p></div>
                                </div>
                            </td>
                            <td><?= number_format((float)$p['prix'], 2) ?> TND</td>
                            <td>
                                <form action="panier_action.php" method="post" class="qte-form">
                                    <input type="hidden" name="action" value="modifier">
                                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                                    <input type="number" name="quantite" min="1" value="<?= $qte ?>">
                                    <button>OK</button>
                                </form>
                            </td>
                            <td><strong><?= number_format($sousTotal, 2) ?> TND</strong></td>
                            <td><a href="panier_action.php?action=supprimer&id=<?= $p['id'] ?>" class="supp">Supprimer</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <aside class="resume bloc">
                <h2>Résumé</h2>
                <div><span>Articles</span><strong><?= $nb ?></strong></div>
                <div class="total"><span>Total</span><strong><?= number_format($total, 2) ?> TND</strong></div>
                <a href="commande.php" class="btn full">Valider</a>
                <a href="panier_action.php?action=vider" class="vider">Vider le panier</a>
            </aside>
        </section>
    <?php endif; ?>
</main>
<?php include 'footer.php'; ?>
</body></html>
