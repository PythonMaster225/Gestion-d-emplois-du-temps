<?php
header('Content-Type: application/json');
require 'db.php';

$stmt = $pdo->query("SELECT codeUE, libUE, coefUE, noSemestre FROM ue ORDER BY codeUE");
echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
?>
