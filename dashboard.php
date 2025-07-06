<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: connexion.php");
    exit();
}



?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7fa;
            color: var(--text-color);
            line-height: 1.6;
        }

        .dashboard-container {
            display: grid;
            grid-template-columns: 250px 1fr;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            background-color:  #f76b21;
            color: white;
            padding: 20px 0;
        }

        .logo {
            text-align: center;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logo h2 {
            font-weight: 500;
        }

        .nav-menu {
            margin-top: 30px;
        }

        .nav-item {
            margin-bottom: 5px;
        }

        .nav-item a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }

        .nav-item a:hover, .nav-item.active a {
            background-color: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .nav-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            padding: 20px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header h1 {
            font-weight: 500;
            color: var(--dark-color);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            border-left: 4px solid var(--secondary-color);
        }

        .stat-card.warning {
            border-left-color: var(--warning-color);
        }

        .stat-card.success {
            border-left-color: var(--success-color);
        }

        .stat-card.danger {
            border-left-color: var(--danger-color);
        }

        .stat-card h3 {
            font-size: 14px;
            color: #777;
            margin-bottom: 10px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-card .change {
            font-size: 12px;
            color: var(--success-color);
        }

        .stat-card .change.negative {
            color: var(--danger-color);
        }

        /* Recent Activity */
        .activity-section {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .section-header h2 {
            font-size: 18px;
            font-weight: 500;
        }

        .section-header a {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 14px;
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            display: flex;
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--light-color);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--secondary-color);
        }

        .activity-details {
            flex: 1;
        }

        .activity-title {
            font-weight: 500;
            margin-bottom: 5px;
        }

        .activity-time {
            font-size: 12px;
            color: #777;
        }

        

       
        
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <sidebar class="sidebar">
            <div class="logo">
                <h2>Club Universitaire</h2>
            </div>

            <nav class="nav-menu">
                <div class="nav-item active">
                    <a href="#">
                        <i class="fas fa-tachometer-alt"></i>
                        Tableau de bord
                    </a>
                </div>
                <div class="nav-item">
                    <a href="profil.php">
                        <i class="fas fa-user"></i>
                        Mon Profil
                    </a>
                </div>
                
                <div class="nav-item">
                    <a href="membre.php">
                        <i class="fas fa-users"></i>
                        Membres
                    </a>
                </div>
                <div class="nav-item">
                    <a href="creer_evenement.php">
                        <i class="fas fa-calendar-alt"></i>
                       Organiser Événements
                    </a>
                </div>
                
            <div class="nav-item">
                    <a href="club_membre.php">
                        <i class="fas fa-users"></i>
                        Clubs
                    </a>
                </div>
                <div class="nav-item">
                    <a href="evenement.php">
                        <i class="fas fa-calendar-alt"></i>
                        Événements
                    </a>
                </div>
                <div class="nav-item">
    <a href="messagerie.php">
        <i class="fas fa-comments"></i>
        Messagerie
    </a>
</div>

                
                
            </nav>
       </sidebar>

        <!-- Main Content -->
        <main class="main-content">
            <header class="header">
                <h1>Tableau de Bord</h1>
                <div class="user-info">
                <ul class="nav nav-tabs">
   
   <li class="nav-item dropdown">
     <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" style="color:black;">
        <i class="fas fa-user"></i>
        Votre Espace
    </a>
     <ul class="dropdown-menu">
       <li><a class="dropdown-item" href="logout.php" style="color:black;">Deconnexion</a></li>
       
     </ul>
   </li>
  
 </ul>
            
           
        </div>
            </header>

            <!-- Recent Activity -->
            <div class="activity-section">
                <div class="section-header">
                    <h2>Activité récente</h2>
                    <a href="anonce.php" style="color:#f76b21;">Voir tous</a>
                </div>
                
            </div>
 
           
            
               
                
   
        </main>
        
    </div>
</body>
</html>