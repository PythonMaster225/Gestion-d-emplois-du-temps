<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');
require 'db.php'; // ← assure-toi que ce fichier existe

//echo json_encode(['debug' => $_POST]);  // 👈 Ajoute temporairement cette ligne
//exit;

$nom = trim($_POST['nomClasse'] ?? '');

if ($nom === '') {
    echo json_encode(['ok'=>false,'message'=>'Nom manquant']);
    exit;
}

try {
    $pdo->prepare("INSERT INTO classe (nomClasse) VALUES(?)")
        ->execute([$nom]);
    echo json_encode(['ok'=>true]);
} catch (PDOException $e) {
    echo json_encode(['ok'=>false,'message'=>$e->getMessage()]);
}

?>