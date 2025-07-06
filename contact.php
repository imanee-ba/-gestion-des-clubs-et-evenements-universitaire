<?php
require_once 'bd_inscrire.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $sql = "INSERT INTO contacte (nom, email, message) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $email, $message]);

    echo "<div class='alert alert-success text-center'>📨 Message envoyé avec succès !</div>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contactez-nous</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            min-height: 100vh;
            background:  #f76b21;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .glass-box {
            background: rgba(245, 243, 243, 0.64);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            max-width: 650px;
            width: 100%;
            color: #333;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        }

        .glass-box h2 {
            font-size: 2rem;
            margin-bottom: 25px;
            text-align: center;
        }

        .glass-box input,
        .glass-box textarea {
            padding: 12px;
            border-radius: 12px;
            border: none;
            background-color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
        }

        .glass-box textarea {
            resize: vertical;
            min-height: 120px;
        }

        .btn-send {
            background-color: #ff6600;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .btn-send:hover {
            background-color: #e65c00;
            transform: scale(1.05);
        }

        .footer-text {
            margin-top: 30px;
            text-align: center;
            font-size: 0.9rem;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="glass-box">
<img src="logo.jpg"style="width: 50px;" alt="" >
    <h2> Ecrire un Commentaire !</h2>
    <form method="POST">
        <div class="mb-3">
            <input type="text" name="nom" class="form-control" placeholder="Votre nom complet " required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Votre email" required>
        </div>
        <div class="mb-4">
            <textarea name="message" rows="5" class="form-control" placeholder="Vos commentaire sur l'application" required></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-send">Envoyer le commentaire</button>
        </div>
        <a href="accueil.php" class="btn custom-btn3">Accueil</a>
        <style>
            .custom-btn3{
                background-color: burlywood;
            }
        </style>
    </form>
</div>

</body>
</html>
