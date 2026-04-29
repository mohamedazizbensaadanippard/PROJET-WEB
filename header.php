<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<header class="menu">
    <a href="index.php" class="marque-site">
        <img src="assests/brand/gearhub-icon.svg" class="logo-box" alt="GearHub">
        <div><h2>GearHub</h2><p>Gaming & accessoires</p></div>
    </a>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="panier.php">Panier <span><?= isset($_SESSION['panier']) ? array_sum($_SESSION['panier']) : 0 ?></span></a>
        <?php if (isset($_SESSION['user'])): ?>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="dashboard.php">Dashboard</a>
            <?php else: ?>
                <a href="mes_commandes.php">Mes commandes</a>
            <?php endif; ?>
            <a href="logout.php">Déconnexion</a>
        <?php else: ?>
            <a href="login.php">Connexion</a>
            <a href="register.php">Inscription</a>
        <?php endif; ?>
    </nav>
</header>
