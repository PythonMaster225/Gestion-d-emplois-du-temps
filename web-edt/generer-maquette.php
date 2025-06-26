<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Emplois du Temps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/styles-maquette.css">
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
            <h2>Génération de maquette EDT par classe</h2>
            
            <div class="card">
                <div class="card-header">
                    <h3>Sélectionnez une classe</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <div style="margin-bottom: 15px;">
                            <label for="classe" style="display: block; margin-bottom: 5px; font-weight: 500;">Classe :</label>
                            <select name="classe" id="classe" class="form-control" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                                <?php
                                // Connexion à la base de données
                                $host = 'localhost';
                                $dbname = 'gestion_edt';
                                $username = 'root';
                                $password = '';
                                
                                try {
                                    $dbh = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
                                    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    
                                    // Récupération des classes
                                    $query = "SELECT noClasse, nomClasse FROM classe ORDER BY nomClasse";
                                    $stmt = $dbh->query($query);
                                    
                                    echo '<option value="">-- Sélectionnez une classe --</option>';
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . htmlspecialchars($row['noClasse']) . '">' . htmlspecialchars($row['nomClasse']) . '</option>';
                                    }
                                } catch (PDOException $e) {
                                    echo '<option value="">Erreur de connexion à la base de données</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="generer">Générer la maquette</button>
                    </form>
                </div>
            </div>
            
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generer'])) {
                $noClasse = $_POST['classe'] ?? '';
                
                if (!empty($noClasse)) {
                    try {
                        // Récupérer le nom de la classe
                        $query = "SELECT nomClasse FROM classe WHERE noClasse = :noClasse";
                        $stmt = $dbh->prepare($query);
                        $stmt->bindParam(':noClasse', $noClasse);
                        $stmt->execute();
                        $classe = $stmt->fetch();
                        $nomClasse = $classe['nomClasse'] ?? '';
                        
                        // Requête pour récupérer les affectations ECUE pour cette classe
                        $query = "
                            SELECT 
                                ue.codeUE, ue.libUE, 
                                ecue.codeECUE, ecue.libECUE, ecue.coefECUE, 
                                professeur.nom, professeur.prenom,
                                SUM(ecue.nbHeure) as heures
                            FROM affectation_ecue
                            JOIN ecue ON affectation_ecue.codeECUE = ecue.codeECUE
                            JOIN ue ON ecue.codeUE = ue.codeUE
                            JOIN professeur ON affectation_ecue.matricule = professeur.matricule
                            WHERE affectation_ecue.noClasse = :noClasse
                            GROUP BY ue.codeUE, ecue.codeECUE, professeur.matricule
                            ORDER BY ue.codeUE, ecue.codeECUE
                        ";
                        
                        $stmt = $dbh->prepare($query);
                        $stmt->bindParam(':noClasse', $noClasse);
                        $stmt->execute();
                        $affectations = $stmt->fetchAll();
                        
                        // Calculer les totaux par UE
                        $totauxUE = [];
                        foreach ($affectations as $aff) {
                            $codeUE = $aff['codeUE'];
                            if (!isset($totauxUE[$codeUE])) {
                                $totauxUE[$codeUE] = [
                                    'heures' => 0,
                                    'coef' => 0
                                ];
                            }
                            $totauxUE[$codeUE]['heures'] += $aff['heures'];
                            $totauxUE[$codeUE]['coef'] += $aff['coefECUE'];
                        }
                        
                        // Afficher le tableau de maquette
                        echo '<div class="table-container" style="margin-top: 20px;">';
                        echo '<h3>Maquette EDT - Classe ' . htmlspecialchars($nomClasse) . '</h3>';
                        echo '<table class="table table-bordered">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th rowspan="2">Code UE</th>';
                        echo '<th rowspan="2">Nom UE</th>';
                        echo '<th rowspan="2">Code ECUE</th>';
                        echo '<th rowspan="2">HP</th>';
                        echo '<th rowspan="2">Coef</th>';
                        echo '<th colspan="2">Nom Professeur</th>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Nom</th>';
                        echo '<th>Prénom</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';
                        
                        $currentUE = null;
                        foreach ($affectations as $aff) {
                            if ($currentUE !== $aff['codeUE']) {
                                // Afficher la ligne UE seulement si c'est une nouvelle UE
                                if ($currentUE !== null) {
                                    // Afficher le total pour l'UE précédente
                                    echo '<tr style="background-color: #f8f9fa; font-weight: bold;">';
                                    echo '<td colspan="2">Total ' . htmlspecialchars($currentUELib) . '</td>';
                                    echo '<td></td>';
                                    echo '<td>' . htmlspecialchars($totauxUE[$currentUE]['heures']) . '</td>';
                                    echo '<td>' . htmlspecialchars($totauxUE[$currentUE]['coef']) . '</td>';
                                    echo '<td colspan="2"></td>';
                                    echo '</tr>';
                                }
                                
                                $currentUE = $aff['codeUE'];
                                $currentUELib = $aff['libUE'];
                                
                                echo '<tr>';
                                echo '<td>' . htmlspecialchars($aff['codeUE']) . '</td>';
                                echo '<td>' . htmlspecialchars($aff['libUE']) . '</td>';
                            } else {
                                echo '<tr>';
                                echo '<td></td>';
                                echo '<td></td>';
                            }
                            
                            echo '<td>' . htmlspecialchars($aff['codeECUE']) . '</td>';
                            echo '<td>' . htmlspecialchars($aff['heures']) . '</td>';
                            echo '<td>' . htmlspecialchars($aff['coefECUE']) . '</td>';
                            echo '<td>' . htmlspecialchars($aff['nom']) . '</td>';
                            echo '<td>' . htmlspecialchars($aff['prenom']) . '</td>';
                            echo '</tr>';
                        }
                        
                        // Afficher le total pour la dernière UE
                        if ($currentUE !== null) {
                            echo '<tr style="background-color: #f8f9fa; font-weight: bold;">';
                            echo '<td colspan="2">Total ' . htmlspecialchars($currentUELib) . '</td>';
                            echo '<td></td>';
                            echo '<td>' . htmlspecialchars($totauxUE[$currentUE]['heures']) . '</td>';
                            echo '<td>' . htmlspecialchars($totauxUE[$currentUE]['coef']) . '</td>';
                            echo '<td colspan="2"></td>';
                            echo '</tr>';
                        }
                        
                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        
                    
                        
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-danger" style="margin-top: 20px;">';
                        echo 'Erreur lors de la récupération des données : ' . htmlspecialchars($e->getMessage());
                        echo '</div>';
                    }
                } else {
                    echo '<div class="alert alert-warning" style="margin-top: 20px;">';
                    echo 'Veuillez sélectionner une classe valide.';
                    echo '</div>';
                }
            }
            ?>
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


</body>
</html>