<?php
session_start();
require_once "bd_inscrire.php";

$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    echo "Vous devez être connecté pour accéder à vos cartes.";
    exit;
}

// Récupérer les infos de l'utilisateur
$stmt_user = $pdo->prepare("SELECT nom, prenom, email, tel, date_creation FROM users WHERE id = ?");
$stmt_user->execute([$user_id]);
$user = $stmt_user->fetch(PDO::FETCH_ASSOC);

// Récupérer les clubs dans lesquels il est inscrit avec son rôle
$stmt_cartes = $pdo->prepare("
    SELECT c.nom_club, cm.role 
    FROM club_membres cm
    JOIN clubs c ON cm.club_id = c.id
    WHERE cm.user_id = ?
");
$stmt_cartes->execute([$user_id]);
$cartes = $stmt_cartes->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Cartes de membre</title>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f4f4f4;
      padding: 40px;
    }

    .carte {
      width: 500px;
      background: white;
      border-left: 10px solid #f76b21;
      border-radius: 12px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.1);
      padding: 25px;
      display: flex;
      gap: 20px;
      margin: 30px auto;
    }

    .photo-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .photo-section img {
      width: 170px;
      height: 170px;
      border-radius: 50%;
      object-fit: cover;
    }

    .info-section {
      flex: 2;
    }

    .info-section h2 {
      margin-bottom: 10px;
      font-size: 24px;
      color: #333;
    }

    .badge-label {
      display: inline-block;
      background-color: #f76b21;
      color: white;
      padding: 6px 14px;
      border-radius: 25px;
      font-size: 14px;
      margin-bottom: 15px;
    }

    .info-section p {
      font-size: 15px;
      color: #444;
      margin: 6px 0;
    }

    .btn-download {
      margin: 0 auto 50px;
      padding: 10px 20px;
      background-color: #f76b21;
      color: white;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      display: block;
    }

    .btn-download:hover {
      background-color: #e65c19;
    }
  </style>
</head>
<body>

<h2 class="text-center mb-4">Mes cartes de membre</h2>

<?php if (empty($cartes)): ?>
  <p class="text-center">Vous n'êtes inscrit dans aucun club.</p>
<?php else: ?>
  <?php foreach ($cartes as $index => $carte): ?>
    <div>
      <div id="carte<?= $index ?>" class="carte">
        <div class="photo-section">
          <img src="logo.jpg" alt="Image">
        </div>
        <div class="info-section">
          <h2><?= htmlspecialchars($user['prenom'] . ' ' . $user['nom']) ?></h2>
          <div class="badge-label"><?= htmlspecialchars($carte['nom_club']) ?></div>
          <p><strong>Rôle :</strong> <?= htmlspecialchars($carte['role']) ?></p>
          <p><strong>Email :</strong> <?= htmlspecialchars($user['email']) ?></p>
          <p><strong>Téléphone :</strong> <?= htmlspecialchars($user['tel']) ?></p>
          <p><strong>Inscription :</strong> <?= htmlspecialchars($user['date_creation']) ?></p>
        </div>
      </div>
      <button class="btn-download" onclick="telechargerPDF('carte<?= $index ?>', '<?= $carte['nom_club'] ?>')">
        📥 Télécharger carte - <?= htmlspecialchars($carte['nom_club']) ?>
      </button>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<script>
  function telechargerPDF(elementId, nomClub) {
    const element = document.getElementById(elementId);
    html2pdf().from(element).save('carte_' + nomClub + '.pdf');
  }
</script>

</body>
</html>
