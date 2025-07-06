<?php
session_start();
require_once 'bd_inscrire.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("
    SELECT a.titre, a.contenu, a.date_publication
    FROM annonces a 
    JOIN clubs c ON a.club_id = c.id 
    JOIN club_membres cm ON cm.club_id = c.id 
    WHERE cm.user_id = ?
    ORDER BY a.date_publication DESC
");
$stmt->execute([$user_id]);
$annonces = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des annonces</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f6fa;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        h1 {
            color: #f76b21;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-ajouter {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #f76b21;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.3s;
        }

        .btn-ajouter:hover {
            background-color: #d75d1c;
        }

        .annonce {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }

        .annonce:last-child {
            border-bottom: none;
        }

        .annonce h3 {
            color: #333;
            margin-bottom: 8px;
        }

        .annonce p {
            margin: 0;
        }

        .annonce small {
            color: #888;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>📢 Liste des annonces</h1>
    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'president'): ?>
    <a href="publier_anonce.php" class="btn-ajouter">➕ Publier une annonce</a>
<?php endif; ?>


    
    <?php if (!empty($annonces)): ?>
        <?php foreach ($annonces as $annonce): ?>
            <div class="annonce">
                <h3><?= htmlspecialchars($annonce['titre']) ?></h3>
                <p><?= nl2br(htmlspecialchars($annonce['contenu'])) ?></p>
                <small>Publié le <?= htmlspecialchars(date('d/m/Y', strtotime($annonce['date_publication']))) ?></small>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucune annonce disponible pour le moment.</p>
    <?php endif; ?>
</div>
</body>
</html>
