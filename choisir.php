<?php
session_start();
require_once "bd_inscrire.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Rediriger vers la page de connexion
    header("Location: connexion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Choisir une action</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-primary {
            background-color: #f76b21;
            color: white;
        }
        .btn-primary:hover {
            background-color: rgb(238, 166, 128);
            color: white;
        }
    </style>
</head>
<body class="bg-light">

<div class="container text-center mt-5">
<img src="logo.jpg"style="width: 50px;" alt="" >
    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['username']); ?> !</h2>
    <p>Que souhaitez-vous faire ?</p>

    <div class="d-flex justify-content-center gap-4 mt-4">
        <a href="formulaire.php" class="btn btn-primary btn-lg">Créer un club</a>
        <a href="inscrire.php" class="btn btn-primary btn-lg">Inscrivez-vous dans un club</a>
    </div>
</div>

</body>
</html>
