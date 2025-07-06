<?php
session_start();
require 'bd_inscrire.php';

if (!isset($_GET['id'])) {
    die("ID manquant.");
}

$id = $_GET['id'];

// Vérifier que l'utilisateur est bien l'auteur
$stmt = $pdo->prepare("SELECT * FROM message WHERE id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch();

if (!$message || $message['user_id'] != $_SESSION['user_id']) {
    die("Accès non autorisé.");
}

// Supprimer le message
$stmt = $pdo->prepare("DELETE FROM message WHERE id = ?");
$stmt->execute([$id]);

header("Location: messagerie.php");
exit;
?>
