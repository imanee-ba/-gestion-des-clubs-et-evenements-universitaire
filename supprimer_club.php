<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'users');

if (!isset($_SESSION['user_id'])) {
    echo "Vous devez être connecté.";
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Supprimer le club
    $query = "DELETE FROM demande WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: accueil.php");
}
?>
