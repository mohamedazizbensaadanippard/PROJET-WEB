<?php
session_start();
require_once 'connexion.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nom != '' && $email != '' && $password != '') {
        try {
            $req = $pdo->prepare("INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, 'client')");
            $req->execute([$nom, $email, $password]);
            $msg = "Compte créé avec succès. Vous pouvez vous connecter.";
        } catch (Exception $e) {
            $msg = "Erreur : email déjà utilisé.";
        }
    } else {
        $msg = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - GearHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="page">
    <section class="commande-page">
        <form method="post" class="bloc form-client">
            <h2>Créer un compte client</h2>
            <?php if ($msg != ''): ?><p><?= htmlspecialchars($msg) ?></p><?php endif; ?>
            <label>Nom complet</label>
            <input type="text" name="nom" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Mot de passe</label>
            <input type="password" name="password" required>
            <button class="full">Créer le compte</button>
        </form>
        <aside class="resume bloc">
            <h2>Déjà inscrit ?</h2>
            <a href="login.php" class="btn full">Connexion</a>
        </aside>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
