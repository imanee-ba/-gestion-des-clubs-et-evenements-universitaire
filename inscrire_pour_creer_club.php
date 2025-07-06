<?php
session_start(); // On démarre la session tout en haut

// Connexion à la base
$db = new PDO('mysql:host=localhost;port=3308;dbname=users', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom     = $_POST['nom'];
    $prenom  = $_POST['prenom'];
    $email   = $_POST['email'];
    $phone   = $_POST['tel'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Sécurisé
    $filiere = $_POST['filiere'];

    // Vérifier si l'email existe déjà
    $checkEmail = $db->prepare('SELECT COUNT(*) FROM users WHERE email = ?');
    $checkEmail->execute([$email]);
    if ($checkEmail->fetchColumn() > 0) {
        echo "<script>alert('Cet email est déjà utilisé.'); window.history.back();</script>";
        exit();
    }

    // Insérer l'utilisateur
    $stmt = $db->prepare('INSERT INTO users (nom, prenom, email, tel,filiere, password) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute([$nom, $prenom, $email, $phone,$filiere, $password]);

    // Stocker les infos en session
    $user_id = $db->lastInsertId();
    $_SESSION['user_id'] = $user_id;
    $_SESSION['username'] = $prenom . ' ' . $nom;

    // Redirection vers la page avec les boutons
    header("Location: choisir.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscrivez-vous</title>
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

        .custom-btn1 {
            background-color: #e96c3f;
            color: white;
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
                    <h3>Inscrivez-vous</h3>
                    <p class="text-muted">Remplissez le formulaire ci-dessous</p>
                </div>

                <form method="POST">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                        </div>
                        <div class="col">
                            <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                        </div>
                    </div>                    
                    <input type="email" name="email" class="form-control mb-3" placeholder="Email" required>
                    <input type="text" name="filiere" class="form-control mb-3" placeholder="Filière" required>
                    
                    <input type="tel" name="tel" class="form-control mb-3" placeholder="Téléphone" required>


                    <div class="row mb-3">
                        <div class="col">
                            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                        </div>
                    </div>

                    <div class="container mt-3">
                        <button type="submit" class="btn btn-primary">S'inscrire</button>
                        <a href="accueil.php" class="btn custom-btn1">Accueil</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-lg-5 d-none d-lg-block text-center">
            <img src="h.PNG" alt="Illustration" class="illustration mt-3">
            <h5 class="mt-3 text-secondary">Bienvenue dans votre avenir associatif !</h5>
        </div>
    </div>
</div>

</body>
</html>
