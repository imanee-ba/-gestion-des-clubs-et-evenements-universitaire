<?php
session_start();
require_once"bd_inscrire.php";

if(!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'president'){
    header('Location:connexion.php');
    exit();

}

$stmt=$db->query("SELECT nom, prenom , filiere, tel FROM users WHERE role='membre' ");
$membres=$stmt->fetchAll(PDO::FETCH_ASSOC);



?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membre du club</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --success: #4cc9f0;
            --danger: #f72585;
            --warning: #f8961e;
            --light: #f8f9fa;
            --dark: #212529;
            --gray: #6c757d;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f7ff;
            padding: 20px;
            color: var(--dark);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
            padding: 20px;
        }

        h1 {
            color:#f76b21;
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .table-container {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        thead {
            background-color: #f76b21;
            color: white;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            font-weight: 500;
        }

        tbody tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-pending {
            background-color: #fff3bf;
            color: #b78f00;
        }

        .status-accepted {
            background-color: #b2f2bb;
            color: #2b8a3e;
        }

        .status-rejected {
            background-color: #ffc9c9;
            color: #c92a2a;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .btn {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn-accept {
            background-color: var(--success);
            color: white;
        }

        .btn-accept:hover {
            background-color:rgb(181, 113, 76);
        }

        .btn-reject {
            background-color: var(--danger);
            color: white;
        }

        .btn-reject:hover {
            background-color:rgb(228, 41, 135);
        }

        .btn-view {
            background-color: #f76b21;
            color: white;
        }

        .btn-view:hover {
            background-color: #3a56ee;
        }

        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 5px;
        }

        .page-btn {
            padding: 8px 12px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            border-radius: 5px;
        }

        .page-btn.active {
            background-color: #f76b21;
            color: white;
            border-color: #f76b21;
        }

        @media (max-width: 768px) {/*pour que les bouttons sont alignee comme on vois dans l'affichage*/
            th, td {
                padding: 10px 8px;
                font-size: 14px;
            }
            
            .btn {
                padding: 6px 8px;
                font-size: 12px;
            }
            
            .avatar {
                width: 30px;
                height: 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
        <i class="fas fa-user"></i>Membre inscris</h1>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prenom</th>
                        <th>Email</th>
                        <th>Filière</th>
                        <th>Motivation</th>

                        <th>Date</th>
                        
                        
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>

                    <?php foreach ($membres as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['nom'] )?></td>
                        <td><?= htmlspecialchars($m['prenom']) ?></td>
                        <td><?= htmlspecialchars($m['filiere']) ?> </td>
                        <td><?= htmlspecialchars($m['tel']) ?></td>


                    </tr>
                    <?php endforeach; ?>
                </thead>
                <tbody>
            </table>
        </div>
        
       
    </div>

    <script>
        // Fonctionnalité de base pour la démo
        document.querySelectorAll('.btn-accept').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const statusCell = row.querySelector('.status');
                statusCell.className = 'status status-accepted';
                statusCell.textContent = 'Acceptée';
                
                // Remplacer les boutons
                const actionsCell = row.querySelector('.actions');
                actionsCell.innerHTML = `
                    <button class="btn btn-view"><i class="fas fa-eye"></i> Voir</button>
                    <button class="btn btn-reject"><i class="fas fa-ban"></i> Annuler</button>
                `;
            });
        });
        
        document.querySelectorAll('.btn-reject').forEach(btn => {
            btn.addEventListener('click', function() {
                const row = this.closest('tr');
                const statusCell = row.querySelector('.status');
                statusCell.className = 'status status-rejected';
                statusCell.textContent = 'Refusée';
                
                // Remplacer les boutons
                const actionsCell = row.querySelector('.actions');
                actionsCell.innerHTML = `
                    <button class="btn btn-view"><i class="fas fa-eye"></i> Voir</button>
                    <button class="btn btn-accept"><i class="fas fa-redo"></i> Réactiver</button>
                `;
            });
        });
    </script>
</body>
</html>