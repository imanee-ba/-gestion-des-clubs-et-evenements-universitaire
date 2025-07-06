<?php
require_once 'bd_evenement.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $club=$_POST['club'];
    $titre=$_POST['titre'];
    $description=$_POST['description'];
    $date=$_POST['date'];
    $lieu=$_POST['lieu'];

    $sql="INSERT INTO evenement (nom, prenom, club, titre, description, date, lieu)
    VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $result=$stmt->execute([$nom, $prenom, $club, $titre, $description, $date, $lieu]);
    if($result){
        echo "✅ Inscription réussie !";
    }else{
        echo "❌ Une erreur est survenue.";
    }

}
?>