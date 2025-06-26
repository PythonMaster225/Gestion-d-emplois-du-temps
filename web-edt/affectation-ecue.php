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

// Variables pour stocker les sélections
$selectedECUE = isset($_POST['selectedECUE']) ? $_POST['selectedECUE'] : null;
$selectedProf = isset($_POST['selectedProf']) ? $_POST['selectedProf'] : null;
$selectedClass = isset($_POST['selectedClass']) ? $_POST['selectedClass'] : null;

// Traitement de l'ajout d'affectation
if (isset($_POST['addAffectation']) && $selectedECUE && $selectedProf && $selectedClass) {
    try {
        $stmt = $pdo->prepare("INSERT INTO affectation_ecue (codeECUE, matricule, noClasse) VALUES (?, ?, ?)");
        $stmt->execute([$selectedECUE, $selectedProf, $selectedClass]);
        
        // Réinitialiser les sélections après l'ajout
        $selectedECUE = null;
        $selectedProf = null;
        $selectedClass = null;
    } catch (PDOException $e) {
        echo "Erreur lors de l'ajout de l'affectation : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Emplois du Temps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles-affectation.css">
</head>
<body>
 <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>Gestion EDT</h1>
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
            <form method="post" action="">
                <!-- Blocs horizontaux -->
                <div class="horizontal-blocks">
                    <!-- Bloc Liste des ECUE -->
                    <div class="horizontal-block">
                        <div class="horizontal-block-header">
                            <h3><i class="fas fa-book-open"></i> Liste des ECUE</h3>
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                        <div class="horizontal-block-content ecue-list-block">
                            <?php
                            // Récupération des ECUE avec leur semestre
                            $stmt = $pdo->query("
                                SELECT e.codeECUE, e.libECUE, u.noSemestre 
                                FROM ecue e 
                                JOIN ue u ON e.codeUE = u.codeUE
                                ORDER BY e.libECUE
                            ");
                            
                            while ($ecue = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $isActive = ($selectedECUE == $ecue['codeECUE']) ? 'active' : '';
                                echo '<div class="list-item '.$isActive.'" onclick="selectECUE(\''.$ecue['codeECUE'].'\')">
                                        <span>'.$ecue['libECUE'].'</span>
                                        <small>Semestre '.$ecue['noSemestre'].'</small>
                                      </div>';
                            }
                            ?>
                            <input type="hidden" name="selectedECUE" id="selectedECUE" value="<?= $selectedECUE ?>">
                        </div>
                    </div>
                    
                    <!-- Bloc Liste des professeurs -->
                    <div class="horizontal-block">
                        <div class="horizontal-block-header">
                            <h3><i class="fas fa-chalkboard-teacher"></i> Liste des professeurs</h3>
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                        <div class="horizontal-block-content">
                            <?php
                            if ($selectedECUE) {
                                // Récupération des professeurs pour la spécialité de l'ECUE sélectionné
                                $stmt = $pdo->prepare("
                                    SELECT p.matricule, p.nom, p.prenom 
                                    FROM professeur p
                                    JOIN prof_spe ps ON p.matricule = ps.matricule
                                    JOIN ecue e ON ps.noSpe = e.noSpe
                                    WHERE e.codeECUE = ?
                                    ORDER BY p.nom, p.prenom
                                ");
                                $stmt->execute([$selectedECUE]);
                                
                                while ($prof = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $isActive = ($selectedProf == $prof['matricule']) ? 'active' : '';
                                    echo '<div class="list-item '.$isActive.'" onclick="selectProf(\''.$prof['matricule'].'\')">
                                            <span>'.$prof['nom'].' '.$prof['prenom'].'</span>
                                          </div>';
                                }
                            } else {
                                echo '<div class="list-item">Sélectionnez d\'abord une ECUE</div>';
                            }
                            ?>
                            <input type="hidden" name="selectedProf" id="selectedProf" value="<?= $selectedProf ?>">
                        </div>
                    </div>
                    
                    <!-- Bloc Liste des classes -->
                    <div class="horizontal-block">
                        <div class="horizontal-block-header">
                            <h3><i class="fas fa-users"></i> Liste des classes</h3>
                            <i class="fas fa-ellipsis-h"></i>
                        </div>
                        <div class="horizontal-block-content">
                            <?php
                            if ($selectedECUE && $selectedProf) {
                                // Récupération des classes non encore affectées à ce professeur pour cette ECUE
                                $stmt = $pdo->prepare("
                                    SELECT c.noClasse, c.nomClasse 
                                    FROM classe c
                                    WHERE c.noClasse NOT IN (
                                        SELECT noClasse 
                                        FROM affectation_ecue 
                                        WHERE codeECUE = ? AND matricule = ?
                                    )
                                    ORDER BY c.nomClasse
                                ");
                                $stmt->execute([$selectedECUE, $selectedProf]);
                                
                                while ($class = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $isActive = ($selectedClass == $class['noClasse']) ? 'active' : '';
                                    echo '<div class="list-item '.$isActive.'" onclick="selectClass(\''.$class['noClasse'].'\')">
                                            <span>'.$class['nomClasse'].'</span>
                                          </div>';
                                }
                            } else {
                                echo '<div class="list-item">Sélectionnez d\'abord une ECUE et un professeur</div>';
                            }
                            ?>
                            <input type="hidden" name="selectedClass" id="selectedClass" value="<?= $selectedClass ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Bouton d'ajout d'affectation -->
                <?php if ($selectedECUE && $selectedProf && $selectedClass): ?>
                <div style="text-align: center; margin: 20px 0;">
                    <button type="submit" name="addAffectation" class="btn btn-primary">
                        <i class="fas fa-save"></i> Enregistrer l'affectation
                    </button>
                </div>
                <?php endif; ?>
                
                <!-- Bloc Liste des affectations -->
                <div class="table-container">
                    <h3><i class="fas fa-tasks"></i> Liste des affectations</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>ECUE</th>
                                <th>Professeur</th>
                                <th>Classe</th>
                                <th>Volume Horaire</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Récupération des affectations existantes
                            $stmt = $pdo->query("
                                SELECT ae.*, e.libECUE, e.nbHeure, p.nom, p.prenom, c.nomClasse
                                FROM affectation_ecue ae
                                JOIN ecue e ON ae.codeECUE = e.codeECUE
                                JOIN professeur p ON ae.matricule = p.matricule
                                JOIN classe c ON ae.noClasse = c.noClasse
                                ORDER BY e.libECUE, p.nom, c.nomClasse
                            ");
                            
                            while ($affectation = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo '<tr>
                                        <td>'.$affectation['libECUE'].'</td>
                                        <td>'.$affectation['nom'].' '.$affectation['prenom'].'</td>
                                        <td>'.$affectation['nomClasse'].'</td>
                                        <td>'.$affectation['nbHeure'].'h</td>
                                        <td><span class="badge badge-success">Confirmée</span></td>
                                        <td>
                                            <button class="btn btn-primary">Modifier</button>
                                        </td>
                                      </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
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

    <script>
        // Gestion du menu mobile reste inchangée
        
        // Fonctions pour sélectionner ECUE, professeur et classe
        function selectECUE(codeECUE) {
            document.getElementById('selectedECUE').value = codeECUE;
            document.getElementById('selectedProf').value = '';
            document.getElementById('selectedClass').value = '';
            document.forms[0].submit();
        }
        
        function selectProf(matricule) {
            document.getElementById('selectedProf').value = matricule;
            document.getElementById('selectedClass').value = '';
            document.forms[0].submit();
        }
        
        function selectClass(noClasse) {
            document.getElementById('selectedClass').value = noClasse;
            document.forms[0].submit();
        }
    </script>
</body>
</html>