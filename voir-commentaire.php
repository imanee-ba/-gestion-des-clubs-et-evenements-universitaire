<?php
require_once 'bd_inscrire.php';
$sql = "SELECT nom, email, message, date_envoi FROM contacte ORDER BY date_envoi DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vos commentaires</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            max-width: 900px;
            margin-top: 60px;
        }

        .card {
            border: none;
            border-left: 6px solid #f76b21;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            padding: 20px;
        }

        .card .card-title {
            font-size: 1.2em;
            font-weight: bold;
            color: #333;
        }

        .card .card-subtitle {
            font-size: 0.9em;
            color: #888;
        }

        .card .card-text {
            margin-top: 10px;
            font-size: 1em;
        }

        h2 {
            text-align: center;
            color: #f76b21;
            margin-bottom: 40px;
        }

        .logo {
            width: 60px;
            display: block;
            margin: 0 auto 20px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <img src="logo.jpg" class="logo" alt="Logo">
    <h2><strong>Vos commentaires</strong></h2>

    <?php if (!empty($messages)): ?>
        <?php foreach ($messages as $msg): ?>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= htmlspecialchars($msg['nom']) ?></h5>
                    <h6 class="card-subtitle mb-2"><?= date('d/m/Y à H:i', strtotime($msg['date_envoi'])) ?></h6>
                    <p class="card-text"><?= nl2br(htmlspecialchars($msg['message'])) ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="alert alert-info text-center">Aucun message reçu pour le moment.</div>
    <?php endif; ?>
</div>

</body>
</html>
