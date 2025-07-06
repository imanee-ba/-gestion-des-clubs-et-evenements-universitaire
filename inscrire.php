<?php
session_start();
require_once "bd_inscrire.php";

$user_id = $_SESSION['user_id'];
$message = "";

// Récupérer la liste des clubs
$clubs = [];
try {
    $stmt = $pdo->query("SELECT id, nom_club FROM clubs");
    $clubs = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $message = "Erreur lors du chargement des clubs.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($_POST['club']) && !empty($_POST['motivation'])) {
        $club_id = $_POST['club'];
        $motivation = $_POST['motivation'];

        // Vérifier si le club existe
        $stmt = $pdo->prepare("SELECT id FROM clubs WHERE id = ?");
        $stmt->execute([$club_id]);
        $club = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($club) {
            // Vérifie si déjà inscrit
            $stmt = $pdo->prepare("SELECT * FROM inscrire WHERE club_id = ? AND user_id = ?");
            $stmt->execute([$club_id, $user_id]);
            $existing_registration = $stmt->fetch(PDO::FETCH_ASSOC);

            // Vérifie si déjà membre
            $stmt_check = $pdo->prepare("SELECT * FROM club_membres WHERE club_id = ? AND user_id = ?");
            $stmt_check->execute([$club_id, $user_id]);
            $existing_membre = $stmt_check->fetch(PDO::FETCH_ASSOC);

            if ($existing_membre) {
                $message = "Vous êtes déjà membre de ce club.";
            } else {
                $stmt_membre = $pdo->prepare("INSERT INTO club_membres (club_id, user_id, role) VALUES (?, ?, 'membre')");
                $stmt_membre->execute([$club_id, $user_id]);

                if ($existing_registration) {
                    $message = "Vous êtes déjà inscrit à ce club.";
                } else {
                    $stmt = $pdo->prepare("INSERT INTO inscrire (club_id, user_id, motivation) VALUES (?, ?, ?)");
                    $stmt->execute([$club_id, $user_id, $motivation]);

                    $_SESSION['message'] = "Vous êtes inscrit avec succès !";
                    header("Location: connexion.php");
                    exit();
                }
            }
        } else {
            $message = "Le club spécifié n'existe pas.";
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription dans un club</title>
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
                    <h3>Inscription dans un club !</h3>
                    <p class="text-muted">Remplissez le formulaire ci-dessous</p>
                </div>

                <?php if (!empty($message)): ?>
                    <div class="alert alert-info text-center">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <!-- Liste déroulante des clubs -->
                    <div class="mb-3">
                        <label for="club" class="form-label">Choisissez un club :</label>
                        <select name="club" id="club" class="form-control" required>
                            <option value="">-- Sélectionner un club --</option>
                            <?php foreach ($clubs as $club): ?>
                                <option value="<?= $club['id'] ?>"><?= htmlspecialchars($club['nom_club']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Motivation -->
                    <div class="mb-3">
                        <input type="text" name="motivation" id="motivation" class="form-control" placeholder="Votre motivation" required>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="accept" required>
                        <label class="form-check-label" for="accept">
                            J'accepte de recevoir des messages
                        </label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" name="Envoyer" class="btn btn-primary">S'inscrire</button>
                        <a href="accueil.php" class="btn btn-secondary">Accueil</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5 d-none d-lg-block text-center">
            <img src="tt.PNG" alt="Illustration" class="illustration mt-3">
            <h5 class="mt-3 text-secondary">Bienvenue dans votre avenir associatif!</h5>
        </div>
    </div>
</div>

</body>
</html>
