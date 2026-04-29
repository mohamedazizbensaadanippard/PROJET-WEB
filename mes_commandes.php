<?php
require_once 'auth.php';
obligerConnexion();
require_once 'connexion.php';

$req = $pdo->prepare("SELECT * FROM commandes WHERE user_id = ? ORDER BY id DESC");
$req->execute([$_SESSION['user']['id']]);
$cmds = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Mes commandes</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'header.php'; ?>
<main class="page">
    <section class="haut-page"><div><p class="mini-title">Client</p><h1>Mes commandes</h1></div></section>
    <?php if (empty($cmds)): ?>
        <div class="bloc message"><h2>Aucune commande</h2><p>Vous n'avez pas encore passé de commande.</p></div>
    <?php else: ?>
        <section class="table-box bloc">
            <table>
                <thead><tr><th>ID</th><th>Total</th><th>Date</th></tr></thead>
                <tbody>
                <?php foreach ($cmds as $c): ?>
                    <tr>
                        <td><?= $c['id'] ?></td>
                        <td><?= number_format((float)$c['total'], 2) ?> TND</td>
                        <td><?= $c['date_commande'] ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    <?php endif; ?>
</main>
<?php include 'footer.php'; ?>
</body></html>
