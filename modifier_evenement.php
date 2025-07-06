<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: connexion.php");
    exit;
}
try{
    $db = new PDO('mysql:host=localhost;port=3308;dbname=users','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("SELECT role FROM club_membres WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $role = $stmt->fetchColumn();

    if($role !== 'president'){
        die("Accès refusé.");
    }
    if(isset($_GET['id'])){
        $eventId = $_GET['id'];

        $stmt = $db->prepare("SELECT * FROM evenement WHERE id = ?");
        $stmt->execute([$eventId]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$eventId){
            die("Evenement introuvable.");
        }
        
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $titre = $_POST['titre'];
            $description = $_POST['description'];
            $lieu = $_POST['lieu'];
            $date = $_POST['date'];
            $delai = $_POST['delai'];

            $stmt = $db->prepare("UPDATE evenement SET titre = ? ,description = ?, lieu = ?, date_event = ?, delai = ? WHERE id = ?");
            $stmt->execute([$titre,$description,$lieu,$date,$delai,$eventId]);

            header("Location: evenement.php");
            exit;
        }

    }else{
        echo"ID manquant.";
        exit;
    }
}catch(PDOEXception $e){
    echo "Erreur : " . $e->getMessage();
}



?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('m.PNG'); /* Remplace par le chemin de ton image */
            background-size: cover;
            
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 16px;
            padding: 30px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .btn-primary {
            background-color: #f76b21;
            border-color: #f76b21;
        }

        .btn-primary:hover {
            background-color: #d55a1a;
            border-color: #d55a1a;
        }

        h2 {
            color: #f76b21;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Modifier l'Événement</h2>
    <form method="POST">
        <div class="mb-3">
            <label for="titre" class="form-label">Titre</label>
            <input type="text" class="form-control" id="titre" name="titre" value="<?= htmlspecialchars($event['titre']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="lieu" class="form-label">Lieu</label>
            <input type="text" class="form-control" id="lieu" name="lieu" value="<?= htmlspecialchars($event['lieu']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="date_event" class="form-label">Date</label>
            <input type="date" class="form-control" id="date_event" name="date_event" value="<?= htmlspecialchars($event['date_event']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="delai" class="form-label">Délai d’inscription</label>
            <input type="text" class="form-control" id="delai" name="delai" value="<?= htmlspecialchars($event['delai']) ?>" required>
        </div>
        <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="evenement.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>

</body>
</html>
