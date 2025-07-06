<?php
session_start();

try {
    $db = new PDO('mysql:host=localhost;port=3308;dbname=users', 'root', '');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_club'] ?? '';
    $motivation = $_POST['motivation'] ?? '';
    $description = $_POST['description'] ?? '';
    $user_id = $_SESSION['user_id'];

    // Vérifier unicité du nom de club
    $stmtCheck = $db->prepare("SELECT COUNT(*) FROM clubs WHERE nom_club = ?");
    $stmtCheck->execute([$nom]);
    $exists = $stmtCheck->fetchColumn();

    if ($exists > 0) {
        $message = "<div class='alert alert-danger text-center'>Ce nom de club est déjà utilisé. Veuillez en choisir un autre.</div>";
    } else {
        // Vérification du logo
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $fileTmp = $_FILES['logo']['tmp_name'];
            $fileName = basename($_FILES['logo']['name']);
            $fileType = mime_content_type($fileTmp);

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!in_array($fileType, $allowedTypes)) {
                die("Type de fichier non autorisé.");
            }

            $targetDir = 'uploads/';
            if (!file_exists($targetDir)) {
                mkdir($targetDir, 0777, true);
            }

            $targetPath = $targetDir . uniqid() . '_' . $fileName;
            move_uploaded_file($fileTmp, $targetPath);

            // Insertion en base
            $stmt = $db->prepare('INSERT INTO clubs (nom_club, motivation, description, logo, user_id) VALUES (?, ?, ?, ?, ?)');
            $stmt->execute([$nom, $motivation, $description, $targetPath, $user_id]);
            $club_id = $db->lastInsertId();

            $stmt_mem = $db->prepare("INSERT INTO club_membres (club_id, user_id, role) VALUES (?, ?, 'president')");
            $stmt_mem->execute([$club_id, $user_id]);

            header('Location: voirclub.php');
            exit();
        } else {
            $message = "<div class='alert alert-danger text-center'>Erreur lors du téléchargement du logo.</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création de Club</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f7f9fc;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: scale(1.01);
        }

        .form-control, .btn {
            border-radius: 10px;
        }

        .btn-primary {
            background-color: #ff7f50;
            border-color: #ff7f50;
        }

        .btn-primary:hover {
            background-color: #e96c3f;
        }

        .logo {
            width: 70px;
        }

        .illustration {
            max-width: 100%;
            height: auto;
            border-radius: 15px;
        }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center align-items-center">
        <div class="col-lg-7">
            <div class="card">
                <div class="text-center mb-4">
                    <img src="logo.jpg" alt="Logo" class="logo mb-2">
                    <h3>Création de Club Universitaire</h3>
                    <p class="text-muted">Remplissez le formulaire ci-dessous</p>
                </div>

                <?php if (!empty($message)) echo $message; ?>

                <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="nom_club" class="form-control mb-3" placeholder="Nom du club" required>
                    <input type="text" name="motivation" class="form-control mb-3" placeholder="Motivation" required>
                    <textarea name="description" class="form-control mb-3" rows="3" placeholder="Description du club" required></textarea>

                    <div class="mb-3">
                        <label for="logo" class="form-label">Logo du club</label>
                        <input type="file" class="form-control" id="logo" name="logo" accept="image/*" required>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="accept" required>
                        <label class="form-check-label" for="accept">
                            J'accepte de recevoir des messages
                        </label>
                    </div>

                    <div class="container mt-3">
                        <button type="submit" name="Envoyer" class="btn btn-primary">Créer le club</button>
                        <a href="accueil.php" class="btn btn-secondary">Accueil</a>
                    </div>
                </form>

            </div>
        </div>

        <div class="col-lg-5 d-none d-lg-block text-center">
            <img src="h.PNG" alt="Illustration" class="illustration mt-3">
            <h5 class="mt-3 text-secondary">Bienvenue dans votre avenir associatif!</h5>
        </div>
    </div>
</div>

</body>
</html>
