<?php
require_once "bd_inscrire.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $nom = $_POST['nom'];
    $filiere = $_POST['filiere'];
    $tele = $_POST['telephone'];

    // Vérification complète
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ? AND nom = ? AND filiere = ? AND tel = ?");
    $stmt->execute([$email, $nom, $filiere, $tele]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['reset_email'] = $email;
        header("Location: reset.php?email=" . urlencode($email));
        exit();
    } else {
        $erreur = "Informations incorrectes. Veuillez réessayer.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Mot de passe oublié</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background:rgb(235, 117, 53);
      height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      color: #fff;
    }

    .container {
      background: white;
      padding: 30px 25px;
      border-radius: 15px;
      box-shadow: 0 10px 25px rgba(0,0,0,0.3);
      max-width: 400px;
      width: 100%;
      color: #333;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
      color:  #f76b21;
    }

    label {
      font-weight: 600;
      display: block;
      margin-top: 15px;
    }

    input[type="text"],
    input[type="email"],
    input[type="submit"] {
      width: 100%;
      padding: 12px;
      margin-top: 5px;
      border-radius: 10px;
      border: 1px solid #ccc;
      background: #f8f8f8;
    }

    button {
      background-color: #f76b21;
      color: white;
      border: none;
      padding: 10px 15px;
      margin-top: 20px;
      width: 100%;
      font-weight: bold;
      border-radius: 10px;
      transition: 0.3s;
    }

    button:hover {
      background-color: #fa823c;
    }

    .message {
      color: red;
      font-weight: bold;
      text-align: center;
      margin-top: 10px;
    }
  </style>
</head>

<body>
  <div class="container">
    <h2>Mot de passe oublié ?</h2>

    <?php if (!empty($erreur)): ?>
      <div class="message"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form method="POST">
      <label for="nom">Nom</label>
      <input type="text" name="nom" required>

      <label for="filiere">Filière</label>
      <input type="text" name="filiere" required>

      <label for="telephone">Téléphone</label>
      <input type="text" name="telephone" required>

      <label for="email">Adresse email</label>
      <input type="email" name="email" required>

      <button type="submit">Continuer</button>
    </form>
  </div>
</body>
</html>
