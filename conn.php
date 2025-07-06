

<?php
session_start();
require_once 'bd_login.php'; // ton fichier qui connecte à la base de données

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $mot_passe = $_POST['mot_passe'];

    $stmt = $db->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mot_passe, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // très important
        echo "Connexion réussie.";
        // Rediriger vers la page de création de club
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Email ou mot de passe incorrect.";
    }
}
?>





