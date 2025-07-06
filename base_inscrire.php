<?php
require_once 'bd_inscrire.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $filiere = $_POST['filiere'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $club_souhaite = $_POST['club'];
    $motivation = $_POST['motivation'];
   
   
    $mot_passe = password_hash($_POST['pd'], PASSWORD_DEFAULT);
    

    $sql = "INSERT INTO inscrire (nom, prenom, tel, filiere, email,club_souhaite ,motivation ,mot_passe)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$nom, $prenom, $tel, $filiere, $email, $club_souhaite, $motivation, $mot_passe]);
    if ($result) {
        echo "✅ Inscription réussie !";
    } else {
        echo "❌ Une erreur est survenue.";
    }
    
}


?>