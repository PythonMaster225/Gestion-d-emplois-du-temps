<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'gestion_edt';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Traitement des actions
$action = $_POST['action'] ?? '';
$noDomaine = $_POST['noDomaine'] ?? 0;
$noSpe = $_POST['noSpe'] ?? 0;
$nomSpe = $_POST['nomSpe'] ?? '';

// Gestion des actions AJAX
if ($action) {
    header('Content-Type: application/json');
    
    try {
        switch ($action) {
            case 'getSpecialites':
                $stmt = $pdo->prepare("SELECT * FROM specialite WHERE noDomaine = ?");
                $stmt->execute([$noDomaine]);
                $specialites = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($specialites);
                break;
                
            case 'addSpecialite':
                $stmt = $pdo->prepare("INSERT INTO specialite (nomSpe, noDomaine) VALUES (?, ?)");
                $stmt->execute([$nomSpe, $noDomaine]);
                $newId = $pdo->lastInsertId();
                echo json_encode(['success' => true, 'noSpe' => $newId]);
                break;
                
            case 'updateSpecialite':
                $stmt = $pdo->prepare("UPDATE specialite SET nomSpe = ? WHERE noSpe = ?");
                $stmt->execute([$nomSpe, $noSpe]);
                echo json_encode(['success' => $stmt->rowCount() > 0]);
                break;
                
            case 'deleteSpecialite':
                $stmt = $pdo->prepare("DELETE FROM specialite WHERE noSpe = ?");
                $stmt->execute([$noSpe]);
                echo json_encode(['success' => $stmt->rowCount() > 0]);
                break;
                
            default:
                echo json_encode(['error' => 'Action non reconnue']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
    exit;
}

// Récupération de tous les domaines avec le nombre de spécialités
$domaines = $pdo->query("
    SELECT d.noDomaine, d.nomDomaine, COUNT(s.noSpe) as nbSpecialites
    FROM domaine d
    LEFT JOIN specialite s ON d.noDomaine = s.noDomaine
    GROUP BY d.noDomaine, d.nomDomaine
")->fetchAll(PDO::FETCH_ASSOC);

// Récupération des spécialités du premier domaine par défaut
$firstDomaine = $domaines[0]['noDomaine'] ?? 0;
$specialites = [];
if ($firstDomaine) {
    $stmt = $pdo->prepare("SELECT * FROM specialite WHERE noDomaine = ?");
    $stmt->execute([$firstDomaine]);
    $specialites = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spécialités - Gestion Emplois du Temps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/spe.css">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>Spécialités</h1>
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
            <div class="form-container">
                <!-- Liste des domaines -->
                <div class="domaines-list">
                    <h2>Liste des domaines</h2>
                    <div id="domaines-container">
                        <?php foreach ($domaines as $domaine): ?>
                            <div class="domaine-item <?= $domaine['noDomaine'] == $firstDomaine ? 'active' : '' ?>" 
                                 data-domaine-id="<?= $domaine['noDomaine'] ?>">
                                <?= htmlspecialchars($domaine['nomDomaine']) ?>
                                <span class="badge"><?= $domaine['nbSpecialites'] ?> spécialité<?= $domaine['nbSpecialites'] > 1 ? 's' : '' ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <!-- Détails du domaine sélectionné et spécialités -->
                <div class="domaine-details">
                    <h2>Spécialités du domaine: <span id="domaine-selected-name"><?= htmlspecialchars($domaines[0]['nomDomaine'] ?? '') ?></span></h2>
                    
                    <div class="specialites-list" id="specialites-container">
                        <?php if (empty($specialites)): ?>
                            <div class="empty-state">
                                <i class="fas fa-graduation-cap"></i>
                                <p>Aucune spécialité enregistrée pour ce domaine</p>
                            </div>
                        <?php else: ?>
                            <?php foreach ($specialites as $specialite): ?>
                                <div class="specialite-item" data-specialite-id="<?= $specialite['noSpe'] ?>">
                                    <span><?= htmlspecialchars($specialite['nomSpe']) ?></span>
                                    <div class="actions">
                                        <button title="Modifier"><i class="fas fa-edit"></i></button>
                                        <button title="Supprimer"><i class="fas fa-trash"></i></button>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Formulaire d'ajout de spécialité -->
                    <div class="add-specialite-form">
                        <h3>Ajouter une nouvelle spécialité</h3>
                        <form id="form-add-specialite">
                            <input type="hidden" id="domaine-id" value="<?= $firstDomaine ?>">
                            <div class="form-group">
                                <label for="nom-specialite">Nom de la spécialité</label>
                                <input type="text" id="nom-specialite" placeholder="Entrez le nom de la spécialité" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Enregistrer</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion de la sélection des domaines
            const domaineItems = document.querySelectorAll('.domaine-item');
            
            domaineItems.forEach(item => {
                item.addEventListener('click', function() {
                    // Retirer la classe active de tous les items
                    domaineItems.forEach(i => i.classList.remove('active'));
                    
                    // Ajouter la classe active à l'item cliqué
                    this.classList.add('active');
                    
                    // Mettre à jour le nom du domaine sélectionné
                    const domaineName = this.textContent.split(' ')[0];
                    document.getElementById('domaine-selected-name').textContent = domaineName;
                    
                    // Mettre à jour l'ID du domaine dans le formulaire
                    const domaineId = this.getAttribute('data-domaine-id');
                    document.getElementById('domaine-id').value = domaineId;
                    
                    // Charger les spécialités du domaine sélectionné via AJAX
                    fetchSpecialites(domaineId);
                });
            });
            
            // Fonction pour charger les spécialités d'un domaine
            function fetchSpecialites(domaineId) {
                fetch('specialites.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=getSpecialites&noDomaine=${domaineId}`
                })
                .then(response => response.json())
                .then(data => {
                    const container = document.getElementById('specialites-container');
                    
                    if (data.length === 0) {
                        container.innerHTML = `
                            <div class="empty-state">
                                <i class="fas fa-graduation-cap"></i>
                                <p>Aucune spécialité enregistrée pour ce domaine</p>
                            </div>
                        `;
                    } else {
                        container.innerHTML = data.map(specialite => `
                            <div class="specialite-item" data-specialite-id="${specialite.noSpe}">
                                <span>${specialite.nomSpe}</span>
                                <div class="actions">
                                    <button title="Modifier"><i class="fas fa-edit"></i></button>
                                    <button title="Supprimer"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        `).join('');
                    }
                })
                .catch(error => console.error('Erreur:', error));
            }
            
            // Gestion du formulaire d'ajout de spécialité
            const formAddSpecialite = document.getElementById('form-add-specialite');
            if (formAddSpecialite) {
                formAddSpecialite.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    const nomSpecialite = document.getElementById('nom-specialite').value;
                    const domaineId = document.getElementById('domaine-id').value;
                    
                    // Envoyer la requête AJAX pour ajouter la spécialité
                    fetch('specialites.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=addSpecialite&noDomaine=${domaineId}&nomSpe=${encodeURIComponent(nomSpecialite)}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Réinitialiser le formulaire
                            formAddSpecialite.reset();
                            
                            // Recharger les spécialités
                            fetchSpecialites(domaineId);
                            
                            // Mettre à jour le badge du domaine
                            const activeDomaineItem = document.querySelector('.domaine-item.active');
                            const badge = activeDomaineItem.querySelector('.badge');
                            const currentCount = parseInt(badge.textContent) || 0;
                            badge.textContent = `${currentCount + 1} spécialité${currentCount + 1 > 1 ? 's' : ''}`;
                        }
                    })
                    .catch(error => console.error('Erreur:', error));
                });
            }
            
            // Gestion des actions sur les spécialités (modifier/supprimer)
            document.getElementById('specialites-container').addEventListener('click', function(e) {
                const specialiteItem = e.target.closest('.specialite-item');
                if (!specialiteItem) return;
                
                const specialiteId = specialiteItem.getAttribute('data-specialite-id');
                const specialiteName = specialiteItem.querySelector('span').textContent;
                const domaineId = document.getElementById('domaine-id').value;
                
                if (e.target.closest('button[title="Modifier"]')) {
                    const newName = prompt('Modifier le nom de la spécialité:', specialiteName);
                    
                    if (newName && newName !== specialiteName) {
                        fetch('specialites.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `action=updateSpecialite&noSpe=${specialiteId}&nomSpe=${encodeURIComponent(newName)}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                specialiteItem.querySelector('span').textContent = newName;
                            }
                        })
                        .catch(error => console.error('Erreur:', error));
                    }
                }
                
                if (e.target.closest('button[title="Supprimer"]')) {
                    if (confirm('Êtes-vous sûr de vouloir supprimer cette spécialité ?')) {
                        fetch('specialites.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `action=deleteSpecialite&noSpe=${specialiteId}`
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                specialiteItem.remove();
                                
                                // Mettre à jour le badge du domaine
                                const activeDomaineItem = document.querySelector('.domaine-item.active');
                                const badge = activeDomaineItem.querySelector('.badge');
                                const currentCount = parseInt(badge.textContent) || 0;
                                badge.textContent = `${currentCount - 1} spécialité${currentCount - 1 !== 1 ? 's' : ''}`;
                                
                                // Si plus de spécialités, afficher le message vide
                                if (currentCount - 1 === 0) {
                                    const container = document.getElementById('specialites-container');
                                    container.innerHTML = `
                                        <div class="empty-state">
                                            <i class="fas fa-graduation-cap"></i>
                                            <p>Aucune spécialité enregistrée pour ce domaine</p>
                                        </div>
                                    `;
                                }
                            }
                        })
                        .catch(error => console.error('Erreur:', error));
                    }
                }
            });
        });
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