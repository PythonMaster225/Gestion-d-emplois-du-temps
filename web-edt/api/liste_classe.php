<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
header('Content-Type: application/json');
require 'db.php';

echo json_encode(
   $pdo->query("SELECT noClasse, nomClasse FROM classe ORDER BY noClasse DESC")
       ->fetchAll(PDO::FETCH_ASSOC)
);
?>
