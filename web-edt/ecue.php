<?php
// Connexion à la base de données
require_once 'config.php';

// Récupérer les UE et Spécialités pour les listes déroulantes
try {
    $ues = $pdo->query("SELECT codeUE, libUE FROM ue ORDER BY libUE")->fetchAll(PDO::FETCH_ASSOC);
    $specialites = $pdo->query("SELECT noSpe, nomSpe FROM specialite ORDER BY nomSpe")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ECUE - Gestion Emplois du Temps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles-ecue.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>ECUE</h1>
        </div>
        <div class="header-right">
            <div class="user-profile">
                <span> <small> Responsable Pédagogique </small></span>
            </div>
        </div>
    </div>
    
       <!-- Navigation -->
    <nav class="navbar">
        <div class="mobile-menu-btn">
            <i class="fas fa-bars"></i>
        </div>
        
        <!-- Desktop Menu -->
        <div class="desktop-menu">
            <div class="menu-section">
                <h3>Général</h3>
                <div class="menu-items">
                    <a href="index.php" class="menu-item">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </div>
            </div>
            
            <div class="menu-section">
                <h3>Structure</h3>
                <div class="menu-items">
                    <a href="domaines.php" class="menu-item active">
                        <i class="fas fa-globe"></i>
                        <span>Domaines</span>
                    </a>
                    <a href="specialites.php" class="menu-item">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Spécialités</span>
                    </a>
                    <a href="ue.php" class="menu-item">
                        <i class="fas fa-book"></i>
                        <span>UE</span>
                    </a>
                    <a href="ecue.php" class="menu-item">
                        <i class="fas fa-book-open"></i>
                        <span>ECUE</span>
                    </a>
                </div>
            </div>
            
            <div class="menu-section">
                <h3>Personnel</h3>
                <div class="menu-items">
                    <a href="professeur.php" class="menu-item">
                        <i class="fas fa-chalkboard-teacher"></i>
                        <span>Professeurs</span>
                    </a>
                    <a href="classe.php" class="menu-item">
                        <i class="fas fa-users"></i>
                        <span>Classes</span>
                    </a>
                </div>
            </div>
            <div class="menu-section">
                <h3>EDT</h3>
                <div class="menu-items">
                    <a href="affectation-ecue.php" class="menu-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Affectation</span>
                    </a>
                    <a href="generer-maquette.php" class="menu-item">
                        <i class="fas fa-print"></i>
                        <span>Exporter</span>
                    </a>
                </div>
            </div>

        </div>
        
        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <div class="mobile-menu-section">
                <h3>Général</h3>
                <a href="index.php" class="mobile-menu-item">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </div>
            
            <div class="mobile-menu-section">
                <h3>Structure Pédagogique</h3>
                <a href="domaines.php" class="mobile-menu-item active">
                    <i class="fas fa-globe"></i>
                    <span>Domaines</span>
                </a>
                <a href="specialites.php" class="mobile-menu-item">
                    <i class="fas fa-graduation-cap"></i>
                    <span>Spécialités</span>
                </a>
                <a href="ue.php" class="mobile-menu-item">
                    <i class="fas fa-book"></i>
                    <span>UE</span>
                </a>
                <a href="ecue.php" class="mobile-menu-item">
                    <i class="fas fa-book-open"></i>
                    <span>ECUE</span>
                </a>
            </div>
            
            <div class="mobile-menu-section">
                <h3>Personnel</h3>
                <a href="professeur.php" class="mobile-menu-item">
                    <i class="fas fa-chalkboard-teacher"></i>
                    <span>Professeurs</span>
                </a>
                <a href="classe.php" class="mobile-menu-item">
                    <i class="fas fa-users"></i>
                    <span>Classes</span>
                </a>
            </div>
            
            <div class="mobile-menu-section">
                <h3>Emploi du temps</h3>
                <a href="affectation-ecue.php" class="mobile-menu-item">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Affectation</span>
                </a>
                <a href="generer-maquette.php" class="mobile-menu-item">
                    <i class="fas fa-print"></i>
                    <span>Exporter</span>
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="main-content">
        <div class="content">
            <div class="ecue-container">
                <!-- Bloc Liste des ECUE -->
                <div class="card">
                    <div class="card-header">
                        <h3>Liste des ECUE</h3>
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table id="ecue-table">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Nom</th>
                                        <th>Coeff.</th>
                                        <th>Heures</th>
                                        <th>UE</th>
                                        <th>Spécialité</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="ecue-list">
                                    <!-- Les données seront chargées via AJAX -->
                                    <tr>
                                        <td colspan="7" style="text-align: center;">Chargement en cours...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    <!-- Bloc Ajouter un ECUE -->
        <div class="card">
        <div class="card-header">
        <h3>Ajouter un ECUE</h3>
        <i class="fas fa-plus-circle"></i>
        </div>
        <div class="card-body">
    <!-- Modifiez le formulaire comme suit : -->
    <form id="add-ecue-form">
        <div class="form-group">
            <label for="ecue-code">Code ECUE *</label>
            <input type="text" id="ecue-code" name="ecue-code" required placeholder="Ex: INF101">
        </div>
        
        <div class="form-group">
            <label for="ecue-name">Libellé ECUE *</label>
            <input type="text" id="ecue-name" name="ecue-name" required placeholder="Ex: Algorithmique">
        </div>
        
        <div class="form-group">
            <label for="ecue-coeff">Coefficient *</label>
            <input type="number" id="ecue-coeff" name="ecue-coeff" required min="0" step="0.5" placeholder="Ex: 2">
        </div>
        
        <div class="form-group">
            <label for="ecue-hours">Nombre d'heures *</label>
            <input type="number" id="ecue-hours" name="ecue-hours" required min="1" placeholder="Ex: 30">
        </div>
        
        <div class="form-group">
            <label for="ecue-ue">UE *</label>
            <select id="ecue-ue" name="ecue-ue" required>
                <option value="">Sélectionner une UE</option>
                <?php foreach ($ues as $ue): ?>
                <option value="<?= $ue['codeUE'] ?>"><?= $ue['libUE'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="ecue-specialite">Spécialité *</label>
            <select id="ecue-specialite" name="ecue-specialite" required>
                <option value="">Sélectionner une spécialité</option>
                <?php foreach ($specialites as $specialite): ?>
                <option value="<?= $specialite['noSpe'] ?>"><?= $specialite['nomSpe'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="action-buttons">
            <button type="reset" class="btn" style="background-color: #6c757d; color: white;">Annuler</button>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>
    </form>
        </div>
        </div>
        </div>
        </div>
    </div>
    </div>

    <!-- [Le reste de votre HTML reste inchangé] -->
         <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2025 Gestion EDT - Tous droits réservés</p>
            <div class="footer-links">
                <a href="#">Confidentialité</a>
                <a href="#">Conditions d'utilisation</a>
                <a href="#">Contact</a>
            </div>
        </div>
    </footer>

    <script>
    // Fonction pour charger la liste des ECUE via AJAX
    function loadECUEs() {
        fetch('api/ecue_api.php?action=get_ecues')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const ecueList = document.getElementById('ecue-list');
                    ecueList.innerHTML = '';
                    
                    if (data.ecues.length === 0) {
                        ecueList.innerHTML = '<tr><td colspan="7" style="text-align: center;">Aucun ECUE trouvé</td></tr>';
                        return;
                    }
                    
                    data.ecues.forEach(ecue => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${ecue.codeECUE}</td>
                            <td>${ecue.libECUE}</td>
                            <td>${ecue.coefECUE}</td>
                            <td>${ecue.nbHeure}</td>
                            <td>${ecue.libUE}</td>
                            <td>${ecue.nomSpe}</td>
                            <td>
                                <button class="btn btn-primary edit-btn" data-id="${ecue.codeECUE}" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-primary delete-btn" data-id="${ecue.codeECUE}" style="padding: 5px 10px; font-size: 12px; background-color: #dc3545;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        ecueList.appendChild(row);
                    });
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                document.getElementById('ecue-list').innerHTML = '<tr><td colspan="7" style="text-align: center; color: red;">Erreur lors du chargement des ECUE</td></tr>';
            });
    }

    // Gestion du formulaire d'ajout
    document.getElementById('add-ecue-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        formData.append('action', 'add_ecue');
        
        fetch('api/ecue_api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Réinitialiser le formulaire
                this.reset();
                // Recharger la liste
                loadECUEs();
                // Afficher message
                alert('ECUE ajouté avec succès!');
            } else {
                alert('Erreur: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue');
        });
    });

    // Charger les ECUE au démarrage
    document.addEventListener('DOMContentLoaded', loadECUEs);
    </script>
    <script>
        // Gestion du menu mobile
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
        });
        // Activer le menu actif
        const menuItems = document.querySelectorAll('.menu-item');
        const mobileMenuItems = document.querySelectorAll('.mobile-menu-item');
        const currentPage = window.location.pathname.split('/').pop();
        menuItems.forEach(item => {
            if (item.getAttribute('href') === currentPage) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
        mobileMenuItems.forEach(item => {
            if (item.getAttribute('href') === currentPage) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
        // Mise à jour du titre
        document.querySelector('.header-left h1').textContent = document.querySelector('.menu-item.active span').textContent || 'Gestion EDT';
        
    </script>

</body>
</html>