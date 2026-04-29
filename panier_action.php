<?php
session_start();

$action = $_GET['action'] ?? $_POST['action'] ?? '';
$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

if ($action === 'ajouter' && $id > 0) {
    $_SESSION['panier'][$id] = ($_SESSION['panier'][$id] ?? 0) + 1;
}

if ($action === 'modifier' && $id > 0) {
    $quantite = max(1, (int)($_POST['quantite'] ?? 1));
    $_SESSION['panier'][$id] = $quantite;
}

if ($action === 'supprimer' && $id > 0) {
    unset($_SESSION['panier'][$id]);
}

if ($action === 'vider') {
    $_SESSION['panier'] = [];
}

header('Location: panier.php');
exit;
?>
