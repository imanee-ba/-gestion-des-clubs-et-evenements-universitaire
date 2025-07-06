<?php
session_start();

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // ou une autre page de connexion
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'users',port:'3308');

// Vérifier la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer l'ID du club depuis l'URL
if (isset($_GET['id'])) {
    $club_id = $_GET['id'];

    // Sélectionner les infos du club
    $stmt = $conn->prepare("SELECT * FROM demande WHERE id = ?");
    $stmt->bind_param("i", $club_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $club = $result->fetch_assoc();

    // Si pas de club trouvé
    if (!$club) {
        echo "Club introuvable.";
        exit();
    }

    // Vérifier si l'utilisateur est bien le créateur du club
    if ($club['user_id'] != $_SESSION['user_id']) {
        echo "Vous n'avez pas la permission de modifier ce club.";
        exit();
    }
}

// Traitement du formulaire de modification
if (isset($_POST['modifier'])) {
    $nouveau_nom = $_POST['nom_club'];
    $nouvelle_description = $_POST['description'];

    $update = $conn->prepare("UPDATE demande SET nom_club = ?, description = ? WHERE id = ?");
    $update->bind_param("ssi", $nouveau_nom, $nouvelle_description, $club_id);
    $update->execute();

    header("Location: accueil.php"); // Retourner à la page principale après modification
    exit();
}
?>

<!-- Formulaire HTML pour modifier -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Club</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Modifier le Club</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="nom_club" class="form-label">Nom du Club</label>
            <input type="text" class="form-control" id="nom_club" name="nom_club" value="<?= htmlspecialchars($club['nom_club']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($club['description']) ?></textarea>
        </div>
        <button type="submit" name="modifier" class="btn btn-primary">Enregistrer les modifications</button>
        <a href="accueil.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
</body>
</html>
