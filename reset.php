<?php
require_once "bd_inscrire.php";
session_start();
if(!isset($_GET['email'])){
    header("Location: pass_oublie.php");
    exit();

}
$email = $_GET['email'];

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $new_pass = $_POST["new_password"];
    $hashed_pass = password_hash($new_pass, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
    $succes = $stmt->execute([$hashed_pass, $email]);

    if($succes){
        echo"Mot de passe mis a jour avec succes ! <a href='connexion.php'>Connexion</a>";
        exit();
    }else{
        $erreur = "Erreur lors de la mis a jour. ";
    }
}



?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Nouveau mot de passe</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script></form>

    </head>
    <body>
        <h2 style="color:#ff7f50;text-align:center;">Reinitialiser votre mot de passe</h2>
        <?php if(!empty($erreur)) echo"<p style='color:red;'>$erreur</p>"; ?>
        <form method="POST">
        <div class="container">
                  <img src="tt.PNG"  style="float: right; width: 350px">
          </div>
            <div class="container mt-3" style="font-size: 25px; max-width: 400px; text-align: left;">
            <label>Nouveau mot de passe :</label>
            <input type="password"class="form-control mb-2" name="new_password" required>
            <button  class="custom-btn" type="submit">Changer le mot de passe </button>
            <style>
    .custom-btn{
                background-color:#f76b21;
                color:white;
              
              }
</style>
</div>
        </form>

    </body>
</html>