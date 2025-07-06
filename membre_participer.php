<?php
session_start();
require_once 'bd_inscrire.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? null;

if ($role !== 'president') {
    header("Location: dashboard.php");
    exit;
}

// Récupérer l'ID du club du président
$stmtClub = $pdo->prepare("SELECT id FROM clubs WHERE user_id = :user_id");
$stmtClub->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmtClub->execute();
$club = $stmtClub->fetch(PDO::FETCH_ASSOC);

if (!$club) {
    echo "Aucun club trouvé pour ce président.";
    exit;
}

$club_id = $club['id'];

// Récupérer les participations aux événements de ce club
$stmt = $pdo->prepare("
    SELECT p.id AS participation_id, e.titre, u.nom, u.prenom, p.date_participation
    FROM participer p
    JOIN evenement e ON p.evenement_id = e.id
    JOIN users u ON p.user_id = u.id
    WHERE e.club_id = :club_id
    ORDER BY e.date_event DESC, p.date_participation DESC
");
$stmt->bindParam(':club_id', $club_id, PDO::PARAM_INT);
$stmt->execute();
$participations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des participations</title>
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

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #f76b21;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Liste des participations aux événements</h1>

    <table>
        <thead>
            <tr>
                <th>Événement</th>
                <th>Membre</th>
                <th>Date de participation</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($participations)): ?>
                <?php foreach ($participations as $participation): ?>
                    <tr>
                        <td><?= htmlspecialchars($participation['titre']) ?></td>
                        <td><?= htmlspecialchars($participation['nom'] . ' ' . $participation['prenom']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($participation['date_participation']))) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">Aucune participation trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>




