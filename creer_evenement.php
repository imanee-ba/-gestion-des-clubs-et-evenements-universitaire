<?php
session_start();
require_once "bd_inscrire.php";

if (!isset($_SESSION['user_id'])) {
    echo "Veuillez vous connecter pour accéder à cette page.";
    exit();
}

$user_id = $_SESSION['user_id'];

// Vérifier le rôle de l'utilisateur
$query = "SELECT role FROM club_membres WHERE user_id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user || $user['role'] !== 'president') {
    echo "Accès refusé. Cette page est réservée aux présidents de clubs.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_club = $_POST['nom_club'];
    $description = $_POST['description'];
    $titre = $_POST['titre'];
    $date = $_POST['date'];
    $lieu = $_POST['lieu'];
    $delai = $_POST['delai'];

    // Vérifier si le club existe
    $stmt = $pdo->prepare("SELECT id FROM clubs WHERE nom_club = ?");
    $stmt->execute([$nom_club]);
    $club = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$club) {
        header("Location: creer_evenement.php?status=error");
        exit();
    }

    $club_id = $club['id'];

    // Vérifier unicité date + lieu
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM evenement WHERE date_event = ? AND lieu = ?");
    $stmt->execute([$date, $lieu]);
    $existing = $stmt->fetchColumn();

    if ($existing > 0) {
        header("Location: creer_evenement.php?status=duplicate");
        exit();
    }

    // Gérer l'image
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $filetmp = $_FILES['logo']['tmp_name'];
        $fileName = basename($_FILES['logo']['name']);
        $fileType = mime_content_type($filetmp);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if (!in_array($fileType, $allowedTypes)) {
            die("Type de fichier non autorisé.");
        }

        $targetDir = 'uploads/';
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetPath = $targetDir . uniqid() . '_' . $fileName;
        move_uploaded_file($filetmp, $targetPath);

        // Insertion
        $stmt = $pdo->prepare("INSERT INTO evenement (club_id, description, titre, date_event, lieu, delai, image) 
                              VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$club_id, $description, $titre, $date, $lieu, $delai, $targetPath]);

        header("Location: creer_evenement.php?status=success");
        exit();
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Organiser evenement</title>
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

        .btn-custom-btn1 {
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
                    <h3>Organiser un evenement</h3>
                    <p class="text-muted">Remplissez le formulaire ci-dessous</p>
                </div>

                <?php if (isset($_GET['status'])): ?>
                    <?php if ($_GET['status'] == 'success'): ?>
                        <div class="alert alert-success text-center">Événement enregistré avec succès !</div>
                    <?php elseif ($_GET['status'] == 'error'): ?>
                        <div class="alert alert-danger text-center">Club introuvable. Veuillez vérifier le nom.</div>
                    <?php elseif ($_GET['status'] == 'duplicate'): ?>
                        <div class="alert alert-warning text-center">Un événement est déjà prévu à cette date et à ce lieu.</div>
                    <?php endif; ?>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data">
                    <input type="text" name="nom_club" class="form-control mb-3" placeholder="Nom du club" required>
                    <input type="text" name="titre" class="form-control mb-3" placeholder="Titre d'evenement" required>
                    <textarea name="description" class="form-control mb-3" rows="3" placeholder="Description d'evenement" required></textarea>
                    <label for="date_event" class="form-label">Date d'evenement</label>
                    <input type="date" name="date" class="form-control mb-3" required>
                    <input type="text" name="lieu" class="form-control mb-3" placeholder="Lieu d'evenement" required>
                    <label for="delai" class="form-label">Le dernier delai</label>
                    <input type="date" name="delai" class="form-control mb-3" required>
                    <label for="logo" class="form-label">Image d'evenement</label>
                    <input type="file" class="form-control" id="logo" name="logo" accept="image/*" required>

                    <div class="container mt-3">
                        <button type="submit" name="Envoyer" class="btn btn-primary">Créer l'événement</button>
                        <a href="dashboard.php" class="btn custom-btn1">Retour au tableau de bord</a>
                        <style>
                            .custom-btn1 {
                                background-color: rgb(221, 185, 172);
                            }
                        </style>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5 d-none d-lg-block text-center">
            <img src="s.PNG" alt="Illustration" class="illustration mt-3">
            <h5 class="mt-3 text-secondary">Bienvenue dans votre avenir associatif!</h5>
        </div>
    </div>
</div>

</body>
</html>
