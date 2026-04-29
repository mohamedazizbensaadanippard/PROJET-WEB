<?php
require_once 'auth.php';
obligerAdmin();
require_once 'connexion.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action == 'ajouter') {
        $req = $pdo->prepare("INSERT INTO produits (nom, marque, categorie, description, prix, stock, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $req->execute([
            $_POST['nom'], $_POST['marque'], $_POST['categorie'], $_POST['description'],
            $_POST['prix'], $_POST['stock'], $_POST['image'] ?: 'assests/products/default.svg'
        ]);
        $msg = "Produit ajouté.";
    }

    if ($action == 'modifier') {
        $req = $pdo->prepare("UPDATE produits SET prix=?, stock=? WHERE id=?");
        $req->execute([$_POST['prix'], $_POST['stock'], $_POST['id']]);
        $msg = "Produit modifié.";
    }

    if ($action == 'supprimer') {
        $req = $pdo->prepare("DELETE FROM produits WHERE id=?");
        $req->execute([$_POST['id']]);
        $msg = "Produit supprimé.";
    }

    if ($action == 'reset_stock') {
        $pdo->query("UPDATE produits SET stock = 50");
        $msg = "Stock réinitialisé à 50.";
    }
}

$produits = $pdo->query("SELECT * FROM produits ORDER BY id")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Admin Produits</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'header.php'; ?>
<main class="page">
    <section class="haut-page">
        <div><p class="mini-title">Admin</p><h1>Gestion produits</h1></div>
        <a href="dashboard.php" class="btn btn2">Dashboard</a>
    </section>

    <?php if ($msg != ''): ?><div class="bloc message"><p><?= htmlspecialchars($msg) ?></p></div><?php endif; ?>

    <section class="commande-page">
        <form method="post" class="bloc form-client">
            <h2>Ajouter produit</h2>
            <input type="hidden" name="action" value="ajouter">
            <label>Nom</label><input type="text" name="nom" required>
            <label>Marque</label><input type="text" name="marque" required>
            <label>Catégorie</label><input type="text" name="categorie" required>
            <label>Description</label><input type="text" name="description" required>
            <label>Prix</label><input type="number" step="0.01" name="prix" required>
            <label>Stock</label><input type="number" name="stock" required>
            <label>Image</label><input type="text" name="image" placeholder="assests/products/default.svg">
            <button class="full">Ajouter</button>
        </form>

        <aside class="resume bloc">
            <h2>Action rapide</h2>
            <form method="post">
                <input type="hidden" name="action" value="reset_stock">
                <button class="full">Reset stock à 50</button>
            </form>
        </aside>
    </section>

    <section class="table-box bloc" style="margin-top:24px">
        <table>
            <thead><tr><th>ID</th><th>Produit</th><th>Prix</th><th>Stock</th><th>Modifier</th><th>Supprimer</th></tr></thead>
            <tbody>
            <?php foreach ($produits as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nom']) ?></td>
                    <td>
                        <form method="post" class="qte-form">
                            <input type="hidden" name="action" value="modifier">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <input type="number" step="0.01" name="prix" value="<?= $p['prix'] ?>">
                    </td>
                    <td><input type="number" name="stock" value="<?= $p['stock'] ?>"></td>
                    <td><button>OK</button></form></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="id" value="<?= $p['id'] ?>">
                            <button onclick="return confirm('Supprimer ce produit ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php include 'footer.php'; ?>
</body></html>
