<?php 
session_start();
require_once"bd_inscrire.php";

$stmt=$db->query("SELECT * FROM evenement ORDER BY date_event DESC");
$evenement=$stmt->fetchAll(PDO::FETCH_ASSOC);




?>





<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Événements</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f7ff;
            color: var(--dark);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            color: #f76b21;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .subtitle {
            color: var(--gray);
            font-size: 1.1rem;
        }

        /* Section Ajout d'événement */
        .add-event-section {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .section-title {
            display: flex;
            align-items: center;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .section-title i {
            margin-right: 10px;
            font-size: 1.5rem;
        }

        .add-event-btn {
            background: #f76b21;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .add-event-btn:hover {
            background: #f76b21;
            transform: translateY(-2px);
        }

        /* Tableau des événements */
        .events-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        }

        .events-table thead {
            background-color: #f76b21;
            color: white;
        }

        .events-table th {
            padding: 1rem;
            text-align: left;
            font-weight: 500;
        }

        .events-table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }

        .events-table tbody tr:last-child td {
            border-bottom: none;
        }

        .events-table tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .action-btns {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }
            
            .events-table {
                display: block;
                overflow-x: auto;
            }
            
            .action-btns {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Gestion des Événements</h1>
            <p class="subtitle">Organisez et gérez les événements de votre club</p>
        </div>

        <!-- Section Ajout d'événement -->
        <section class="add-event-section">
            <h2 class="section-title">
                <i class="fas fa-calendar-plus"></i> Ajouter un événement
            </h2>
            
            <a href="creer_evenement.php" style="text-decoration: none; display: inline-block;">
        <button class="add-event-btn">
            <i class="fas fa-plus"></i> Créer un nouvel événement
        </button>
    </a>
            
        </section>

        <!-- Section Événements organisés -->
        <section>
            <h2 class="section-title">
                <i class="fas fa-calendar-check"></i> Événements Organisés
            </h2>
            
            <table class="events-table">
                <thead>
                    <tr>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Date</th>
                        <th>Lieu</th>
                        
                    </tr>
                    <?php foreach ($evenement as $event): ?>
                    <tr>
                        <th><?= htmlspecialchars($event['titre'])?></th>
                        <th><?= htmlspecialchars($event['description']) ?></th>
                        <th><?= htmlspecialchars($event['date_event']) ?></th>
                        <th><?= htmlspecialchars($event['lieu']) ?></th>

                        <?php if($_SESSION['role'] === 'president'): ?>
                            <a href="modifier_evenement.php?id=<?= $event['id'] ?>">Modifier</a>
                           <a href="supprimer_evenement.php?id=<?= $event['id'] ?>">Supprimer</a>
                      <?php endif; ?>
                    </tr>
                    <?php endforeach; ?>
                </thead>
                
            </table>
        </section>
    </div>

    
</body>
</html>