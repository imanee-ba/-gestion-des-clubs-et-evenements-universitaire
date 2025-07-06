<?php
$db = new PDO('mysql:host=localhost;port=3308;dbname=users', 'root', '');//connexion a la base de donnees
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$clubs = $db->query("SELECT * FROM clubs")->fetchAll(PDO::FETCH_ASSOC);//ona stocker dans le variable clubs le resutat de la selection qu'on a fait de la table clubs
?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" conmtent="width=device-width,initial-scale=1, shrink-to-fit=no">
        <meta name="keywords"content>
        <meta name="description"content>
        <meta name="author"content>
        <title>nos clubs</title>
        <link rel="stylesheet"type="text/css"href="css/bootstrap.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <h1 style="text-align: center; color:#ff6600;">Nos Clubs</h1>
    <div class="row g-4">
        
          <div class="col-md-6">
      <!-- Clubs dynamiques issus de la base de données -->
<div class="container mt-4">
    <div class="row">
        <?php if (!empty($clubs)): ?>
            <?php foreach ($clubs as $club): ?>
                <div class="col-md-4 mb-4">
                    <div class="card club-card h-100">
                        <img src="<?= htmlspecialchars($club['logo']) ?>" class="card-img-top" alt="Logo du club" style="max-height: 200px; object-fit: contain;">
                        <div class="card-body text-center">
    <h5 class="card-title"><?= htmlspecialchars($club['nom_club']) ?></h5>
   
</div>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Aucun club n'est disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>
</div>

          






          </div>
          <div class="container mt-3">
           
            <a href="accueil.php" class="btn custom-btn3">Accueil</a>
            
            <style>
              .btn-sm{
                background-color: #ff6600;
                text-align: center;
                color: white;
              }
              .btn-sm:hover{
                box-shadow: 0 4px 12px rgba(0,0,0,0.1);
              }


              .custom-btn4 {
                background-color: #ff6600;
                text-align: center;
                color: white;
              }
              .custom-btn3 {
                background-color: #ff6600;
                text-align: center;
                color: white;
              }

            </style>
          </div>




          <style>
            
            .club-box:hover {
              box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            }
            .club-img {
              width: 50px;
              height: auto;
              margin-bottom: 20px;
            }
        </style>
        





</body>
</html>