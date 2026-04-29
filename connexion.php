<?php
$host = 'localhost';
$port = '5432';
$dbname = 'boutique';
$user = 'postgres';
$password = '1234';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password, [
        ]);
} catch (PDOException $e) {
    die('Erreur de connexion : ' . $e->getMessage());
}
?>
