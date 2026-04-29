<?php
session_start();
require_once 'connexion.php';

$msg = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $req = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $req->execute([$email]);
    $user = $req->fetch();

    if ($user && $user['password'] === $password) {
        $_SESSION['user'] = $user;

        if ($user['role'] === 'admin') {
            header('Location: dashboard.php');
        } else {
            header('Location: index.php');
        }
        exit;
    } else {
        $msg = "Email ou mot de passe incorrect.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - GearHub</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?>
<main class="page">
    <section class="commande-page">
        <form method="post" class="bloc form-client">
            <h2>Connexion</h2>
            <?php if ($msg != ''): ?><p class="supp"><?= htmlspecialchars($msg) ?></p><?php endif; ?>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Mot de passe</label>
            <input type="password" name="password" required>
            <button class="full">Se connecter</button>
            <p>Admin : admin@gearhub.com / admin123</p>
        </form>
        <aside class="resume bloc">
            <h2>Pas de compte ?</h2>
            <p>Créez un compte client pour passer une commande.</p>
            <a href="register.php" class="btn full">Inscription</a>
        </aside>
    </section>
</main>
<?php include 'footer.php'; ?>
</body>
</html>
