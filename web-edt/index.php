<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Emplois du Temps</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/styles-domaines.css">
<style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --header-height: 60px;
            --navbar-height: 50px;
            --menu-bg: #2c3e50;
            --menu-active: #34495e;
            --content-bg: #ecf0f1;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        /* Header Styles */
        .header {
            height: var(--header-height);
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        .header-left {
            display: flex;
            align-items: center;
        }
        
        .header-left h1 {
            color: #333;
            font-size: 22px;
        }
        
        .header-right {
            display: flex;
            align-items: center;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Navigation Styles */
        .navbar {
            background-color: var(--menu-bg);
            color: white;
            height: var(--navbar-height);
            display: flex;
            align-items: center;
            position: sticky;
            top: var(--header-height);
            z-index: 99;
        }
        
        .desktop-menu {
            display: flex;
            width: 100%;
            height: 100%;
        }
        
        .menu-section {
            display: flex;
            align-items: center;
            padding: 0 15px;
            height: 100%;
            position: relative;
        }
        
        .menu-section h3 {
            color: #bdc3c7;
            font-size: 14px;
            margin-right: 15px;
            text-transform: uppercase;
        }
        
        .menu-items {
            display: flex;
            height: 100%;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 0 15px;
            cursor: pointer;
            height: 100%;
            transition: all 0.3s;
        }
        
        .menu-item:hover {
            background-color: var(--menu-active);
        }
        
        .menu-item.active {
            background-color: var(--menu-active);
            border-bottom: 3px solid var(--primary-color);
        }
        
        .menu-item i {
            margin-right: 8px;
            font-size: 14px;
        }
        
        /* Mobile Menu Button */
        .mobile-menu-btn {
            display: none;
            cursor: pointer;
            font-size: 24px;
            color: white;
            padding: 0 20px;
        }
        
        /* Mobile Menu */
        .mobile-menu {
            position: fixed;
            top: calc(var(--header-height) + var(--navbar-height));
            left: 0;
            width: 100%;
            background-color: var(--menu-bg);
            z-index: 98;
            transform: translateY(-100%);
            opacity: 0;
            transition: all 0.3s ease;
            pointer-events: none;
        }
        
        .mobile-menu.active {
            transform: translateY(0);
            opacity: 1;
            pointer-events: all;
        }
        
        .mobile-menu-section {
            padding: 10px 0;
            border-bottom: 1px solid #34495e;
        }
        
        .mobile-menu-section h3 {
            color: #bdc3c7;
            font-size: 14px;
            padding: 5px 20px;
            text-transform: uppercase;
        }
        
        .mobile-menu-item {
            padding: 10px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .mobile-menu-item:hover {
            background-color: var(--menu-active);
        }
        
        .mobile-menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Styles */
        .main-content {
            padding-top: 20px;
            min-height: calc(100vh - var(--header-height) - var(--navbar-height));
        }
        
        .content {
            padding: 0 20px 20px;
            background-color: var(--content-bg);
            min-height: calc(100vh - var(--header-height) - var(--navbar-height) - 20px);
        }
        
        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .card {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }
        
        .card-header h3 {
            color: #333;
        }
        
        .card-header i {
            font-size: 24px;
            color: var(--primary-color);
        }
        
        .card-body p {
            color: #666;
            margin-bottom: 10px;
        }
        
        .card-footer {
            display: flex;
            justify-content: flex-end;
        }
        
        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
        }
        
        .table-container {
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 20px;
            overflow-x: auto;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        table th {
            background-color: #f8f9fa;
            color: #333;
            font-weight: 600;
        }
        
        table tr:hover {
            background-color: #f5f5f5;
        }
        
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .desktop-menu {
                display: none;
            }
            
            .mobile-menu-btn {
                display: block;
            }
            
            .menu-section h3 {
                display: none;
            }
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="header-left">
            <h1>Gestion EDT</h1>
        </div>
        <div class="header-right">
            <div class="user-profile">
                <span>Responsable Pédagogique</span>
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
            <div class="card-container">
                <div class="card">
                    <div class="card-header">
                        <h3>Domaines</h3>
                        <i class="fas fa-globe"></i>
                    </div>
                    <div class="card-body">
                        <p>Gestion des domaines de formation</p>
                        <?php
                        // Connexion à la base de données
                        $db = new PDO('mysql:host=localhost;dbname=gestion_edt;charset=utf8', 'root', '');
                        
                        // Compter le nombre de domaines
                        $req = $db->query("SELECT COUNT(*) as nb FROM domaine");
                        $nbDomaines = $req->fetch()['nb'];
                        ?>
                        <p>Nombre de domaines: <strong><?= $nbDomaines ?></strong></p>
                    </div>
                    <div class="card-footer">
                        <button onclick="getPage('domaines')" class="btn btn-primary">Gérer</button>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3>Spécialités</h3>
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <div class="card-body">
                        <p>Gestion des spécialités</p>
                        <?php
                        // Compter le nombre de spécialités
                        $req = $db->query("SELECT COUNT(*) as nb FROM specialite");
                        $nbSpecialites = $req->fetch()['nb'];
                        ?>
                        <p>Nombre de spécialités: <strong><?= $nbSpecialites ?></strong></p>
                    </div>
                    <div class="card-footer">
                        <button onclick="getPage('specialites')" class="btn btn-primary">Gérer</button>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3>UE</h3>
                        <i class="fas fa-book"></i>
                    </div>
                    <div class="card-body">
                        <p>Gestion des Unités d'Enseignement</p>
                        <?php
                        // Compter le nombre d'UE
                        $req = $db->query("SELECT COUNT(*) as nb FROM ue");
                        $nbUE = $req->fetch()['nb'];
                        ?>
                        <p>Nombre d'UE: <strong><?= $nbUE ?></strong></p>
                    </div>
                    <div class="card-footer">
                        <button onclick="getPage('ue')" class="btn btn-primary">Gérer</button>
                    </div>
                </div>
            </div>
            
            <div class="table-container">
                <h3>Derniers cours assignés</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Classe</th>
                            <th>Professeur</th>
                            <th>ECUE</th>
                            <th>Heures</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Récupérer les dernières affectations ECUE
                        $req = $db->query("
                            SELECT 
                                c.nomClasse, 
                                p.nom, 
                                p.prenom, 
                                e.libECUE,
                                e.nbHeure,
                                a.idAffectationECUE
                            FROM 
                                affectation_ecue a
                            JOIN classe c ON a.noClasse = c.noClasse
                            JOIN professeur p ON a.matricule = p.matricule
                            JOIN ecue e ON a.codeECUE = e.codeECUE
                            ORDER BY a.idAffectationECUE DESC
                            LIMIT 10
                        ");
                        
                        while ($affectation = $req->fetch()) {
                            echo '<tr>
                                <td>'.$affectation['nomClasse'].'</td>
                                <td>'.$affectation['prenom'].' '.$affectation['nom'].'</td>
                                <td>'.$affectation['libECUE'].'</td>
                                <td>'.$affectation['nbHeure'].'</td>
                                <td><span class="badge badge-warning">En cours</span></td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
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
        
        // Fonction pour charger une page
        function getPage(page) {
            window.location.href = page + '.php';
        }


    </script>


</body>
</html>