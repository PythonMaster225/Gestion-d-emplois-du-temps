<?php

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


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_professeur'])) {
    $matricule = $_POST['matricule'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $tel = $_POST['tel'];
    $specialite_id = $_POST['specialite'];

    try {
        
        $pdo->beginTransaction();

      
        $stmt = $pdo->prepare("INSERT INTO professeur (matricule, nom, prenom, email, tel) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$matricule, $nom, $prenom, $email, $tel]);

        
        if ($specialite_id) {
           

          
            $stmt = $pdo->prepare("INSERT INTO prof_spe (matricule, noSpe) VALUES (?, ?)");
            $stmt->execute([$matricule, $specialite_id]);
        }

        
        $pdo->commit();
        
        
        header("Location: professeur.php?success=1");
        exit();
    } catch (PDOException $e) {
        
        $error_message = "Erreur lors de l'ajout du professeur : " . $e->getMessage();
    }



}


$professeurs = $pdo->query("SELECT * FROM professeur ORDER BY nom, prenom")->fetchAll(PDO::FETCH_ASSOC);


$specialites = $pdo->query("SELECT * FROM specialite ORDER BY nomSpe")->fetchAll(PDO::FETCH_ASSOC);


// Insertion 
// Traitement de l'ajout de spécialité à un professeur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajouter_specialites'])) {
    $matricule_prof = $_POST['matricule_prof'];
    $specialites_selectionnees = $_POST['specialites'] ?? [];

    try {
        $pdo->beginTransaction();
        
        foreach ($specialites_selectionnees as $noSpe) {
            $stmt = $pdo->prepare("INSERT INTO prof_spe (matricule, noSpe) VALUES (?, ?)");
            $stmt->execute([$matricule_prof, $noSpe]);
        }
        
        $pdo->commit();
        header("Location: professeur.php?success=2&matricule=".$matricule_prof);
        exit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        $error_message = "Erreur lors de l'ajout des spécialités : " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professeurs - Gestion Emplois du Temps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/prof.css">
    <link rel="stylesheet" href="css/index.css">
        <style>
        .dual-blocks {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }
        .block {
            flex: 1;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .prof-list {
            list-style: none;
            padding: 0;
        }
        .prof-list li {
            padding: 10px;
            border-bottom: 1px solid #eee;
            cursor: pointer;
            transition: background 0.2s;
        }
        .prof-list li:hover, .prof-list li.active {
            background: #f5f5f5;
        }
        .specialites-container {
            display: none;
        }
        .specialites-container.active {
            display: block;
        }
        .specialite-item {
            margin: 5px 0;
        }
        #specialites-form {
            margin-top: 15px;
        }
        #save-btn {
            display: none;
            margin-top: 10px;
        }
    </style>
</head>
<body>
 
    <div class="header">
        <div class="header-left">
            <h1>Professeurs</h1>
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
    
  
    <div class="main-content">
        <div class="content">
            <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
                <div class="alert alert-success">
                    Professeur ajouté avec succès!
                </div>
            <?php endif; ?>
            
            <?php if (isset($error_message)): ?>
                <div class="alert alert-error">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            
           
            <div class="form-container">
                <h2>Ajouter un nouveau professeur</h2>
                <form method="POST" action="professeur.php">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="matricule">Matricule</label>
                            <input type="text" id="matricule" name="matricule" required placeholder="Entrez le matricule">
                        </div>
                        <div class="form-group">
                            <label for="nom">Nom</label>
                            <input type="text" id="nom" name="nom" required placeholder="Entrez le nom">
                        </div>
                        <div class="form-group">
                            <label for="prenom">Prénom</label>
                            <input type="text" id="prenom" name="prenom" required placeholder="Entrez le prénom">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" required placeholder="Entrez l'email">
                        </div>
                        <div class="form-group">
                            <label for="tel">Téléphone</label>
                            <input type="tel" id="tel" name="tel" required placeholder="Entrez le numéro de téléphone">
                        </div>
                        <div class="form-group">
                            <label for="specialite">Spécialité</label>
                            <select id="specialite" name="specialite">
                                <option value="">-- Sélectionnez une spécialité --</option>
                                <?php foreach ($specialites as $specialite): ?>
                                    <option value="<?= htmlspecialchars($specialite['noSpe']) ?>">
                                        <?= htmlspecialchars($specialite['nomSpe']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    
                    <button type="submit" name="ajouter_professeur" class="btn btn-primary">Enregistrer</button>
                </form>
            </div>
            
           
            <!-- Nouvelle structure à deux blocs -->
            <div class="dual-blocks">
                <!-- Bloc 1: Liste des enseignants -->
                <div class="block">
                    <h2>Liste des enseignants</h2>
                    <?php if (empty($professeurs)): ?>
                        <p>Aucun professeur enregistré pour le moment.</p>
                    <?php else: ?>
                        <ul class="prof-list">
                            <?php foreach ($professeurs as $prof): ?>
                                <li onclick="loadSpecialites('<?= $prof['matricule'] ?>', this)">
                                    <?= htmlspecialchars($prof['nom']) ?> <?= htmlspecialchars($prof['prenom']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
                
                <!-- Bloc 2: Liste des spécialités -->
                <div class="block">
                    <h2>Liste des spécialités</h2>
                    <div id="specialites-container" class="specialites-container">
                        <p>Sélectionnez un professeur pour voir ses spécialités disponibles</p>
                        <form id="specialites-form" method="POST">
                            <input type="hidden" id="matricule_prof" name="matricule_prof">
                            <div id="specialites-list"></div>
                            <button type="submit" id="save-btn" name="ajouter_specialites" class="btn btn-primary">Enregistrer</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        function loadSpecialites(matricule, element) {
            // Mettre en surbrillance le professeur sélectionné
            document.querySelectorAll('.prof-list li').forEach(li => {
                li.classList.remove('active');
            });
            element.classList.add('active');
            
            // Afficher le conteneur des spécialités
            document.getElementById('specialites-container').classList.add('active');
            document.getElementById('matricule_prof').value = matricule;
            
            // Charger les spécialités disponibles via AJAX
            fetch('api/get_specialites.php?matricule=' + matricule)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('specialites-list').innerHTML = html;
                    document.getElementById('save-btn').style.display = 'none';
                });
        }
        
        // Fonction pour afficher le bouton Enregistrer quand une spécialité est cochée
        function toggleSaveButton() {
            const checkboxes = document.querySelectorAll('input[name="specialites[]"]:checked');
            document.getElementById('save-btn').style.display = checkboxes.length > 0 ? 'block' : 'none';
        }
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