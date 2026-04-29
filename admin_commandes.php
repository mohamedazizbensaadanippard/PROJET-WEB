<?php
require_once 'auth.php';
obligerAdmin();
require_once 'connexion.php';

$cmds = $pdo->query("SELECT * FROM commandes ORDER BY id DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Admin Commandes</title><link rel="stylesheet" href="style.css"></head>
<body>
<?php include 'header.php'; ?>
<main class="page">
    <section class="haut-page"><div><p class="mini-title">Admin</p><h1>Commandes</h1></div></section>
    <section class="table-box bloc">
        <table>
            <thead><tr><th>ID</th><th>Client</th><th>Email</th><th>Total</th><th>Date</th></tr></thead>
            <tbody>
            <?php foreach ($cmds as $c): ?>
                <tr>
                    <td><?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['nom_client']) ?></td>
                    <td><?= htmlspecialchars($c['email_client']) ?></td>
                    <td><?= number_format((float)$c['total'], 2) ?> TND</td>
                    <td><?= $c['date_commande'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</main>
<?php include 'footer.php'; ?>
</body></html>
