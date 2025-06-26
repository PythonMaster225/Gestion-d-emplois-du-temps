<?php
require_once '../config.php'; // Fichier avec les paramètres de connexion PDO

$matricule = $_GET['matricule'] ?? '';

try {
    // Récupérer les spécialités déjà affectées à ce professeur
    $stmt = $pdo->prepare("SELECT noSpe FROM prof_spe WHERE matricule = ?");
    $stmt->execute([$matricule]);
    $specialites_affectees = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Récupérer toutes les spécialités
    $specialites = $pdo->query("SELECT * FROM specialite ORDER BY nomSpe")->fetchAll(PDO::FETCH_ASSOC);
    
    // Afficher les spécialités non affectées
    echo '<h3>Spécialités disponibles</h3>';
    foreach ($specialites as $specialite) {
        if (!in_array($specialite['noSpe'], $specialites_affectees)) {
            echo '<div class="specialite-item">';
            echo '<input type="checkbox" name="specialites[]" id="spe_'.$specialite['noSpe'].'" value="'.$specialite['noSpe'].'" onclick="toggleSaveButton()">';
            echo '<label for="spe_'.$specialite['noSpe'].'">'.htmlspecialchars($specialite['nomSpe']).'</label>';
            echo '</div>';
        }
    }
    
    // Afficher les spécialités déjà affectées (en lecture seule)
    if (!empty($specialites_affectees)) {
        echo '<h3 style="margin-top:20px;">Spécialités déjà affectées</h3>';
        foreach ($specialites as $specialite) {
            if (in_array($specialite['noSpe'], $specialites_affectees)) {
                echo '<div class="specialite-item">';
                echo '<input type="checkbox" checked disabled>';
                echo '<label>'.htmlspecialchars($specialite['nomSpe']).'</label>';
                echo '</div>';
            }
        }
    }
    
} catch (PDOException $e) {
    echo '<p class="error">Erreur lors du chargement des spécialités</p>';
}
?>