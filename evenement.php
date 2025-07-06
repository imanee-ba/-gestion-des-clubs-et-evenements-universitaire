<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;port=3308;dbname=users', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Récupère les événements avec les infos club
$stmt = $db->query("
    SELECT e.*, c.nom_club, c.user_id AS club_president_id
    FROM evenement e 
    JOIN clubs c ON e.club_id = c.id 
    ORDER BY e.date_event DESC
");

$user_id = $_SESSION['user_id'] ?? null;
$ispresident = false;

// Vérifie si l'utilisateur est président
if ($user_id) {
    $stmtRole = $db->prepare("SELECT role FROM club_membres WHERE user_id = ?");
    $stmtRole->execute([$user_id]);
    $role = $stmtRole->fetchColumn();
    $ispresident = ($role === 'president');
}

$evenements = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Événements</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
            padding: 20px;
        }

        .event-card {
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            max-width: 600px;
            margin: auto;
            margin-bottom: 30px;
        }

        .btn {
            background-color: #f76b21;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1em;
        }

        .btn:hover {
            background-color: #d1581f;
        }

        .ps {
            background-color: #fff6e0;
            padding: 12px;
            border-left: 4px solid #e8b100;
            margin-bottom: 24px;
            font-size: 14px;
        }
    </style>
</head>
<body class="bg-light">

            <a href="dashboard.php" class="btn btn-secondary">Retour au tableau de bord</a>
<div class="container py-5">
    <h2 class="mb-4 text-center" style="color:#f76b21;">Événements organisés</h2>
    <div class="row">
        <?php foreach ($evenements as $event): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <?php if (!empty($event['image'])): ?>
                        <img src="<?= htmlspecialchars($event['image']) ?>" class="card-img-top" alt="Image événement">
                    <?php else: ?>
                        <img src="o.PNG" class="card-img-top" alt="Image par défaut">
                    <?php endif; ?>

                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($event['titre']) ?></h5>
                        <p class="card-text"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                        <ul class="list-unstyled text-muted">
                            <li><strong>Club :</strong> <?= htmlspecialchars($event['nom_club']) ?></li>
                            <li><strong>Date :</strong> <?= htmlspecialchars($event['date_event']) ?></li>
                            <li><strong>Lieu :</strong> <?= htmlspecialchars($event['lieu']) ?></li>
                            <li class="ps"><strong>Delai de participation :</strong> <?= htmlspecialchars($event['delai']) ?></li>
                        </ul>
                        <a href="participer.php">
                            <button type="button" class="btn btn-primary">Participer</button>
                        </a>

                        <?php if ($ispresident && $event['club_president_id'] == $user_id): ?>
                            <div class="mt-3">
                                <a href="modifier_evenement.php?id=<?= $event['id'] ?>" class="btn btn-warning me-2">Modifier</a>
                                <a href="supprimer_evenement.php?id=<?= $event['id'] ?>" class="btn btn-danger"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet événement ?');">Supprimer</a>
                                   <a href="membre_participer.php?id=<?= $event['id'] ?>" class="btn btn-warning me-2">Voir participant</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>
