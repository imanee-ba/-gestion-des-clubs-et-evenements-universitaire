<?php
session_start();
require_once "bd_inscrire.php";

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) {
    echo "Erreur : utilisateur non connecté.";
    exit;
}

$stmt = $pdo->prepare("SELECT club_id FROM club_membres WHERE user_id = ? AND role = 'president'");
$stmt->execute([$user_id]);
$club = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$club) {
    echo "Accès refusé. Cette page est réservée au président.";
    exit;
}

$club_id = $club['club_id'];

$stmt = $pdo->prepare("SELECT users.nom, users.prenom, users.email, users.filiere 
                      FROM club_membres 
                      JOIN users ON club_membres.user_id = users.id 
                      WHERE club_membres.club_id = ? AND club_membres.role = 'membre'");
$stmt->execute([$club_id]);
$membres = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La liste des membres inscrits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       body {
    font-family: 'Roboto', sans-serif;
    background: linear-gradient(to right, #fdfcfb, #e2d1c3);
    padding: 40px 20px;
    color: #444;
}

.container {
    max-width: 1000px;
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    padding: 30px;
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

h1 {
    color: #ff6600;
    font-weight: 700;
    margin-bottom: 30px;
    text-align: center;
}

.table-container {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    border-radius: 10px;
    overflow: hidden;
}

thead {
    background: #ff6600;
    color: white;
}

th, td {
    padding: 16px;
    text-align: center;
    border-bottom: 1px solid #f0f0f0;
}

tbody tr:hover {
    background-color: #fff3e6;
    transition: background 0.3s ease;
}

.alert {
    font-size: 1.1em;
}

.btn-secondary {
    background-color: #444;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    color: white;
    transition: background-color 0.3s ease;
}

.btn-secondary:hover {
    background-color: #222;
}

    </style>
</head>
<body>
<div class="container">
    <h1><i class="fas fa-users"></i> Liste des membres inscrits</h1>

    <div class="table-container">
        <?php if (!empty($membres)): ?>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Filière</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($membres as $membre): ?>
                <tr>
                    <td><?= htmlspecialchars($membre['nom']) ?></td>
                    <td><?= htmlspecialchars($membre['prenom']) ?></td>
                    <td><?= htmlspecialchars($membre['email']) ?></td>
                    <td><?= htmlspecialchars($membre['filiere']) ?></td>
                    <td><a href="supprimer_membre.php?id=<?= $event['id'] ?>" class="btn btn-danger"
                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?');">Supprimer</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p class="alert alert-warning text-center">Aucun membre trouvé dans ce club.</p>
        <?php endif; ?>
    </div>

    <div class="text-center">
        <a href="dashboard.php" class="btn btn-secondary">Retour au tableau de bord</a>
    </div>
</div>
</body>
</html>