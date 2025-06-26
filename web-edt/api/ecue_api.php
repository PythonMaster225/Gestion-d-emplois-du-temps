<?php
header('Content-Type: application/json');
require_once '../config.php';

// Récupérer la liste des ECUE
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'get_ecues') {
    try {
        $query = "SELECT e.*, u.libUE, s.nomSpe 
                  FROM ecue e
                  JOIN ue u ON e.codeUE = u.codeUE
                  JOIN specialite s ON e.noSpe = s.noSpe
                  ORDER BY e.codeECUE";
        $stmt = $pdo->query($query);
        $ecues = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'ecues' => $ecues]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur de base de données: ' . $e->getMessage()]);
    }
    exit;
}

// Ajouter un ECUE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_ecue') {
    // Récupération et validation des données
    $codeECUE = trim($_POST['ecue-code']);
    $libECUE = trim($_POST['ecue-name']);
    $coefECUE = floatval($_POST['ecue-coeff']);
    $nbHeure = intval($_POST['ecue-hours']);
    $codeUE = trim($_POST['ecue-ue']);
    $noSpe = intval($_POST['ecue-specialite']);

    // Validation
    if (empty($codeECUE) || empty($libECUE) || $coefECUE <= 0 || $nbHeure <= 0 || empty($codeUE) || $noSpe <= 0) {
        echo json_encode(['success' => false, 'message' => 'Tous les champs sont obligatoires']);
        exit;
    }

    try {
        // Vérifier si le code ECUE existe déjà
        $stmt = $pdo->prepare("SELECT codeECUE FROM ecue WHERE codeECUE = ?");
        $stmt->execute([$codeECUE]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Ce code ECUE existe déjà']);
            exit;
        }

        // Insertion
        $stmt = $pdo->prepare("INSERT INTO ecue (codeECUE, libECUE, coefECUE, nbHeure, codeUE, noSpe) 
                              VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$codeECUE, $libECUE, $coefECUE, $nbHeure, $codeUE, $noSpe]);

        // Retourner la nouvelle liste
        $query = "SELECT e.*, u.libUE, s.nomSpe 
                  FROM ecue e
                  JOIN ue u ON e.codeUE = u.codeUE
                  JOIN specialite s ON e.noSpe = s.noSpe
                  ORDER BY e.codeECUE";
        $stmt = $pdo->query($query);
        $ecues = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode(['success' => true, 'message' => 'ECUE ajouté avec succès', 'ecues' => $ecues]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur d\'insertion: ' . $e->getMessage()]);
    }
    exit;
}

echo json_encode(['success' => false, 'message' => 'Action non valide']);
?>