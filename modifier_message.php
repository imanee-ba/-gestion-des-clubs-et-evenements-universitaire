<?php
session_start();
require 'bd_inscrire.php';

if (!isset($_GET['id'])) {
    die("ID manquant.");
}

$id = $_GET['id'];

// Vérifier si l'utilisateur est l'auteur du message
$stmt = $pdo->prepare("SELECT * FROM message WHERE id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch();

if (!$message || $message['user_id'] != $_SESSION['user_id']) {
    die("Accès non autorisé.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nouveau_message = $_POST['message'];
    $stmt = $pdo->prepare("UPDATE message SET message = ? WHERE id = ?");
    $stmt->execute([$nouveau_message, $id]);
    header("Location: messagerie.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier le message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
        }
        .edit-container {
            max-width: 600px;
            margin: 80px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .btn-orange {
            background-color: #f76b21;
            color: white;
        }
        .btn-orange:hover {
            background-color: #e25e10;
        }
    </style>
</head>
<body>
<div class="container edit-container">
    <h4 class="mb-4 text-center">✏️ Modifier votre message</h4>
    <form method="POST">
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea name="message" id="message" class="form-control" rows="5" required><?= htmlspecialchars($message['message']) ?></textarea>
        </div>
        <div class="text-end">
            <a href="messagerie.php" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-orange">💾 Enregistrer</button>
        </div>
    </form>
</div>
</body>
</html>
