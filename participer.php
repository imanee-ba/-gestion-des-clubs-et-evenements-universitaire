<?php
session_start();
require_once 'bd_inscrire.php';

$erreur = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION['user_id'])) {
        $erreur = "Utilisateur non connecté.";
    } else {
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $filiere = $_POST['filiere'];
        $email = $_POST['email'];
        $evenement_id = $_POST['evenement_id'];
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO participer (nom, prenom, filiere, email, user_id, evenement_id) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$nom, $prenom, $filiere, $email, $user_id, $evenement_id]);

        if ($result) {
            $success = "✅ Participation réussie !";
        } else {
            $erreur = "❌ Une erreur est survenue lors de l'enregistrement.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Participer à un événement</title>
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
                    <h3>Participer à un événement</h3>
                    <p class="text-muted">Remplissez le formulaire ci-dessous</p>
                </div>

                <?php if ($erreur): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
                <?php elseif ($success): ?>
                    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="col">
                            <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <input type="text" name="filiere" class="form-control" placeholder="Filière" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required>
                    </div>

                    <div class="mb-3">
                        <select name="evenement_id" class="form-control" required>
                            <option value="">-- Choisir un événement --</option>
                            <?php
                            try {
                                $stmt = $pdo->query("SELECT id, titre FROM evenement ORDER BY id DESC");
                                if ($stmt->rowCount() == 0) {
                                    echo "<option disabled>Aucun événement disponible</option>";
                                } else {
                                    while ($evenement = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='" . $evenement['id'] . "'>" . htmlspecialchars($evenement['titre']) . "</option>";
                                    }
                                }
                            } catch (PDOException $e) {
                                echo "<option disabled>Erreur lors du chargement des événements</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-check mb-4">
                        <input class="form-check-input" type="checkbox" id="accept" required>
                        <label class="form-check-label" for="accept">
                            J'accepte de recevoir des messages
                        </label>
                    </div>

                    <!-- ✅ BOUTONS BIEN AFFICHÉS -->
                    <div class="mb-3 d-flex justify-content-between">
                        <button type="submit" name="Participer" class="btn btn-primary px-4">Participer</button>
                        <a href="dashboard.php" class="btn btn-secondary px-4">Retour au tableau de bord</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5 d-none d-lg-block text-center">
            <img src="5.PNG" alt="Illustration" class="illustration mt-3">
            <h5 class="mt-3 text-secondary">Merci pour votre participation!</h5>
        </div>
    </div>
</div>

</body>
</html>
