<?php
session_start();
require_once 'bd_inscrire.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $motdepasse = $_POST['mot_passe'];

    // Récupère l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($motdepasse, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['nom'] = $user['nom'];

        // Récupère le rôle dans club_membres
        $stmtRole = $pdo->prepare("SELECT role FROM club_membres WHERE user_id = ? LIMIT 1");
        $stmtRole->execute([$user['id']]);
        $roleData = $stmtRole->fetch();

        if ($roleData) {
            $_SESSION['role'] = $roleData['role'];  // exemple: 'president', 'membre', etc.
        } else {
            $_SESSION['role'] = 'membre'; // Par défaut si aucun rôle trouvé
        }

        header("Location: dashboard.php");
        exit();
    } else {
        $erreur = "Email ou mot de passe incorrect";
    }
}
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
      body{
       background: url('ss.png');
        font-family:'Poppins',sans-serif;
        background-size: cover;

       
       
      }
      
      .login-box{
        background: white;
  max-width: 350px;
  padding: 30px;
  margin: 10% auto;
  margin-left: 20%; /* Décalage vers la gauche */
  border-radius: 16px;
  box-shadow: 0 8px 20px rgba(0,0,0,0.2);
  text-align: center;

      }
      .logo {
  width: 80px;
  margin-bottom: 15px;
}

.input {
  width: 100%;
  padding: 12px;
  margin: 10px 0;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.btn {
  width: 100%;
  padding: 12px;
  background-color:#ff6600;
  border: none;
  color: white;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  margin-top: 10px;
}

.links {
  margin-top: 15px;
  font-size: 0.9em;
}

.links a {
  color: #333;
  text-decoration: none;
}

      
      
      </style>


</head>
<body>
    <div class="login-box">
        <img src="logo.jpg"class="logo">
        <h2>Connectez-vous</h2>
        <p class="subtitle">Espace Clubs & Événements</p>
        
        <form method="post">
            
            
                
                <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
                <input type="password" name="mot_passe" id="mot_passe" class="form-control" placeholder="Mot de passe" required>
                
            
            <button class="btn">Connexion</button>
            <a href="accueil.php" class="btn custom-btn">Accueil</a>

            <div class="links">
                <a href="pass_oublie.php">Mot de passe oublié ?</a>
                <a href="inscrire_pour_creer_club.php">Créer un compte</a>
            </div>
        </form>
        
    </div>
    
</body>
</html>