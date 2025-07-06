<?php
session_start();
require_once 'demande.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $filiere = $_POST['filiere'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];
    $nom_club = $_POST['nom_club'];
    $motivation = $_POST['motivation'];
    $description = $_POST['description'];
    $mot_passe = password_hash($_POST['pd'], PASSWORD_DEFAULT);
    
    
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
    } else {
        die('Erreur : utilisateur non connecté.');
    }

    // Insertion dans la table demande
    $sql = "INSERT INTO demande (nom, prenom, filiere, tel, email, nom_club, mot_passe, motivation, description, user_id)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $result = $stmt->execute([$nom, $prenom, $filiere, $tel, $email, $nom_club, $mot_passe, $motivation, $description, $user_id]);

    if ($result) {
        echo "Demande ajoutée avec succès.";
    } else {
        echo "Erreur lors de l'ajout de la demande.";
    }
}
?>
