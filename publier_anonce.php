<?php
session_start();
require_once 'bd_inscrire.php';

// Vérifier si l'utilisateur est connecté et est président
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'president') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupérer le club du président
$stmt = $pdo->prepare("SELECT id FROM clubs WHERE user_id = ?");
$stmt->execute([$user_id]);
$club = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$club) {
    echo "Aucun club trouvé pour ce président.";
    exit;
}

$club_id = $club['id'];
$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titre = trim($_POST['titre']);
    $contenu = trim($_POST['contenu']);
    $club = trim($_POST['club']);

    if (!empty($titre) && !empty($contenu)) {
        $stmt = $pdo->prepare("INSERT INTO annonces (club_id,club_nom, titre, contenu, date_publication) VALUES (?,?, ?, ?, NOW())");
        if ($stmt->execute([$club_id,$club, $titre, $contenu])) {
            $success = "Annonce publiée avec succès.";
        } else {
            $error = "Erreur lors de la publication de l'annonce.";
        }
    } else {
        $error = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Publier une annonce</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7ff;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #f76b21;
        }

        label {
            font-weight: bold;
            margin-top: 15px;
            display: block;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        textarea {
            resize: vertical;
            height: 120px;
        }

        .btn {
            background-color: #f76b21;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 20px;
        }

        .success {
            color: green;
            margin-top: 10px;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #f76b21;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Publier une annonce</h2>

        <?php if ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="post">
            <label for="titre">Titre de l'annonce</label>
            <input type="text" name="titre" id="titre" required>

            <label for="contenu">Contenu de l'annonce</label>
            <textarea name="contenu" id="contenu" required></textarea>
            <label for="titre">Club</label>
            <input type="text" name="club" id="club" required>


            <button class="btn" type="submit">Publier</button>
        </form>

        <a class="back-link" href="anonce.php">← Retour à la liste des annonces</a>
    </div>
</body>
</html>
