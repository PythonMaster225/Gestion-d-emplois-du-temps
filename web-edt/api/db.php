<?php
$host = '127.0.0.1';
$db   = 'gestion_edt';
$user = 'root';
$pass = '';          // mot de passe XAMPP par défaut
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    http_response_code(500);
    echo "Erreur connexion BDD : " . $e->getMessage();
    exit;
}
?>
