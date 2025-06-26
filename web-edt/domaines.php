<?php
// config.php - Fichier de configuration de la base de données
$host = 'localhost';
$dbname = 'gestion_edt';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données: " . $e->getMessage());
}

// Si la requête est de type AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    
    // Ajouter un domaine
    if (isset($_POST['action']) && $_POST['action'] == 'add_domaine') {
        $nomDomaine = trim($_POST['nomDomaine']);
        
        if (empty($nomDomaine)) {
            echo json_encode(['success' => false, 'message' => 'Le nom du domaine ne peut pas être vide']);
            exit;
        }
        
        try {
            $stmt = $pdo->prepare("INSERT INTO domaine (nomDomaine) VALUES (:nomDomaine)");
            $stmt->bindParam(':nomDomaine', $nomDomaine);
            $stmt->execute();
            
            // Récupérer tous les domaines après l'ajout
            $domaines = $pdo->query("SELECT * FROM domaine ORDER BY noDomaine DESC")->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'message' => 'Domaine ajouté avec succès',
                'domaines' => $domaines
            ]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'ajout du domaine: ' . $e->getMessage()]);
        }
        exit;
    }
    
    // Récupérer la liste des domaines
    if (isset($_GET['action']) && $_GET['action'] == 'get_domaines') {
        try {
            $domaines = $pdo->query("SELECT * FROM domaine ORDER BY noDomaine DESC")->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(['success' => true, 'domaines' => $domaines]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Erreur lors de la récupération des domaines']);
        }
        exit;
    }
}

// Si ce n'est pas une requête AJAX, afficher la page normale
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domaines - Gestion Emplois du Temps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles-domaines.css">
</head>
<body>
    <!-- [Tout le HTML de votre fichier original reste inchangé jusqu'à la partie script] -->
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>Domaines</h1>
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
            <div class="domaines-container">
                <!-- Bloc Liste des domaines -->
                <div class="card">
                    <div class="card-header">
                        <h3>Liste des domaines</h3>
                        <i class="fas fa-list"></i>
                    </div>
                    <div class="card-body">
                        <div class="table-container">
                            <table id="domaines-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nom du domaine</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="domaines-list">
                                    <!-- La liste des domaines sera chargée via AJAX -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Bloc Ajouter un domaine -->
                <div class="card">
                    <div class="card-header">
                        <h3>Ajouter un domaine</h3>
                        <i class="fas fa-plus-circle"></i>
                    </div>
                    <div class="card-body">
                        <form id="add-domaine-form">
                            <div class="form-group">
                                <label for="domaine-name">Nom du domaine</label>
                                <input type="text" id="domaine-name" name="domaine-name" required placeholder="Ex: Informatique">
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
        // Gestion du menu mobile
        const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('active');
        });
        
        // Fonction pour charger la liste des domaines via AJAX
        function loadDomaines() {
            fetch('?action=get_domaines', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const domainesList = document.getElementById('domaines-list');
                    domainesList.innerHTML = '';
                    
                    data.domaines.forEach(domaine => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${domaine.noDomaine}</td>
                            <td>${domaine.nomDomaine}</td>
                            <td>
                                <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background-color: #dc3545;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        domainesList.appendChild(row);
                    });
                }
            })
            .catch(error => console.error('Erreur:', error));
        }
        
        // Charger les domaines au chargement de la page
        document.addEventListener('DOMContentLoaded', function() {
            loadDomaines();
            
            // Détection de la page active pour le menu
            const currentPage = window.location.pathname.split('/').pop();
            const menuItems = document.querySelectorAll('.menu-item, .mobile-menu-item');
            
            menuItems.forEach(item => {
                const itemHref = item.getAttribute('href');
                if (itemHref === currentPage) {
                    item.classList.add('active');
                } else {
                    item.classList.remove('active');
                }
            });
        });
        
        // Gestion du formulaire d'ajout de domaine avec AJAX
        document.getElementById('add-domaine-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const domaineName = document.getElementById('domaine-name').value.trim();
            
            if (domaineName === '') {
                alert('Veuillez entrer un nom de domaine valide');
                return;
            }
            
            const formData = new FormData();
            formData.append('action', 'add_domaine');
            formData.append('nomDomaine', domaineName);
            
            fetch('', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Réinitialiser le formulaire
                    this.reset();
                    
                    // Mettre à jour la liste des domaines
                    const domainesList = document.getElementById('domaines-list');
                    domainesList.innerHTML = '';
                    
                    data.domaines.forEach(domaine => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${domaine.noDomaine}</td>
                            <td>${domaine.nomDomaine}</td>
                            <td>
                                <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px;">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-primary" style="padding: 5px 10px; font-size: 12px; background-color: #dc3545;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        `;
                        domainesList.appendChild(row);
                    });
                    
                    // Afficher un message de succès
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de l\'ajout du domaine');
            });
        });
    </script>
</body>
</html>