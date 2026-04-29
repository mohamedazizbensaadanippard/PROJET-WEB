<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function estConnecte() {
    return isset($_SESSION['user']);
}

function estAdmin() {
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin';
}

function obligerConnexion() {
    if (!estConnecte()) {
        header('Location: login.php');
        exit;
    }
}

function obligerAdmin() {
    if (!estAdmin()) {
        header('Location: login.php');
        exit;
    }
}
?>
