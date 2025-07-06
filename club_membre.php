<?php
require_once 'bd_inscrire.php';
session_start();

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT c.nom_club FROM clubs c 
                      JOIN inscrire i ON c.id = i.club_id 
                      WHERE i.user_id = ?");
$stmt->execute([$user_id]);
$clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes clubs</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #fefefe, #e3eafc);
            margin: 0;
            padding: 40px 20px;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            color: #f76b21;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        .btn-container {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 20px;
        }

        .add-btn {
            background-color: #f76b21;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.3s;
            text-decoration: none;
        }

        .add-btn:hover {
            background-color: #d95e16;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff5ee;
            border-left: 5px solid #f76b21;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 500;
            margin: 0;
            color: #333;
        }

        .empty {
            text-align: center;
            font-size: 1.1rem;
            color: #999;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="btn-container">
        <a href="inscrire.php" class="add-btn">
            <i class="fas fa-plus"></i> Inscrire dans un club
        </a>
    </div>

    <h1><i class="fas fa-users"></i> Mes clubs</h1>

    <?php if (count($clubs) > 0): ?>
        <div class="cards">
            <?php foreach ($clubs as $club): ?>
                <div class="card">
                    <p class="card-title"><?= htmlspecialchars($club['nom_club']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="empty">Vous n'êtes inscrit dans aucun club.</p>
    <?php endif; ?>
</div>

</body>
</html>
