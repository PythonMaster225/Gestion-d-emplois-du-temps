<?php
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(405);
    echo json_encode(['ok'=>false,'message'=>'Méthode non autorisée']);
    exit;
}
require 'db.php';

$codeUE     = trim($_POST['codeUE'] ?? '');
$libUE      = trim($_POST['libUE'] ?? '');
$coefUE     = intval($_POST['coefUE'] ?? 0);
$noSemestre = intval($_POST['noSemestre'] ?? 0);

if(!$codeUE || !$libUE || $coefUE<=0 || $noSemestre<=0){
    echo json_encode(['ok'=>false,'message'=>'Données incomplètes']);
    exit;
}

/* insertion sécurisée */
$sql = "INSERT INTO ue (codeUE, libUE, coefUE, noSemestre) VALUES (?,?,?,?)";
try{
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$codeUE,$libUE,$coefUE,$noSemestre]);
    echo json_encode(['ok'=>true]);
}catch(PDOException $e){
    // code UE déjà utilisé ?
    echo json_encode(['ok'=>false,'message'=>$e->getMessage()]);
}
?>
