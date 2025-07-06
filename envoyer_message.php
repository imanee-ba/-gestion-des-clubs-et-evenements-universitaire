<?php
session_start();
require 'bd_inscrire.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Récupérer le club de l'utilisateur
$stmt = $pdo->prepare("SELECT club_id FROM club_membres WHERE user_id = ?");
$stmt->execute([$user_id]);
$club_id = $stmt->fetchColumn();

if (!$club_id) {
    die("Aucun club associé.");
}

$message = $_POST['message'] ?? null;
$audio_path = null;

// Gestion du fichier audio
if (isset($_FILES['audio_blob']) && $_FILES['audio_blob']['error'] == 0) {
    $uploadsDir = 'uploads/';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0777, true);
    }

    $filename = uniqid() . '.webm';
    $filePath = $uploadsDir . $filename;

    if (move_uploaded_file($_FILES['audio_blob']['tmp_name'], $filePath)) {
        $audio_path = $filePath;
    }
}

$stmt = $pdo->prepare("INSERT INTO message (user_id, club_id, message, audio_path, created_at) VALUES (?, ?, ?, ?, NOW())");
$stmt->execute([$user_id, $club_id, $message, $audio_path]);

header('Location: messagerie.php');
exit;
?>