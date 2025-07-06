<?php
session_start();
require_once'bd_inscrire.php';

$president_id = $_SESSION['user_id'] ?? null;
$membre_id = $_GET['user_id'] ?? null;

if(!$president_id || !$membre_id){
    die("PARAMETRE MANQUANT.");
}
$stmt = $db->prepare("SELECT club_id FROM club_membres WHERE user_id = ? AND role ='president'");
$stmt->execute([$president_id]);
$club_id = $stmt->fetchColumn();

if($club_id){
    die("Accès refusé.");
}

$stmt = $db->prepare("DELETE FROM club_membres WHERE user_id = ? AND club_id = ? AND role='membre'");
$stmt->execute([$membre_id, $club_id]);

header("Location:membre.php");
exit;


?>