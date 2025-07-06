<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: connexion.php");
    exit;
}
try{
    $db = new PDO ('mysql:host=localhost;port=3308;dbname=users','root','');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $db->prepare("SELECT role FROM club_membres WHERE user_id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $role = $stmt->fetchColumn();

    if($role !=='president'){
        die("Accès refusé.");

    }
    if(isset($_GET['id'])){
        $eventId = $_GET['id'];
        $stmt = $db->prepare("DELETE FROM evenement WHERE id =? ");
        $stmt->execute([$eventId]);
        header("Location: evenement.php");
        exit;
    }else{
        echo"ID d'événement manquant.";
    }

}catch(PDOException $e){
    echo "Erreur: " . $e->getMessage();
}



?>