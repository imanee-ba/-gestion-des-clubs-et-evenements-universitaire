<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>MyClub</title>
  
  <!-- Bootstrap 5.3 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <style>
    body {
      padding-top: 70px;
    }
    .custom-btn1, .custom-btn4, .custom-btn {
      background-color: #f76b21;
      color: white;
    }
    .service-box {
      border: 1px dotted #d3680b;
      padding: 20px;
      height: 100%;
      transition: 0.3s;
    }
    .service-box:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .title-orange, .title {
      color: #ff6600;
      font-weight: bold;
    }
    .service-img {
      width: 50px;
      height: auto;
      margin-bottom: 10px;
    }
    .club-box:hover {
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .club-img {
      width: 200px;
      height: auto;
      margin-bottom: 20px;
    }
    .py-7 {
      padding-top: 80px;
      padding-bottom: 80px;
    }
  </style>
</head>
<body>
  <header class="header_section">
    <nav class="navbar navbar-expand-lg bg-light fixed-top">
      <div class="container-fluid">
        <a class="navbar-brand"><img src="logo.jpg" style="width: 50px;" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link active" style="color: #f76b21;" href="#accueil">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="#propos">Propos</a></li>
            <li class="nav-item"><a class="nav-link" href="#service">Services</a></li>
            <li class="nav-item"><a class="nav-link" href="#club">Clubs</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                Commentaire
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="contact.php">Écrire un commentaire</a></li>
                <li><a class="dropdown-item" href="voir-commentaire.php">Voir les commentaires</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <section id="accueil" class="accueil_section layout_padding-top layout_padding2-bottom">
    <div class="container">
      <div class="row">
        <div class="col-12 col-md-6 d-flex align-items-center">
          <div class="detail-box">
            <h1 style="color: #f76b21;">Bienvenue sur MyClub, votre solution de gestion des clubs et des événements universitaires</h1>
            <h6 style="color:#516287;">Rejoignez votre club, organisez vos événements, et collaborez en toute simplicité !</h6>
          </div>
        </div>
        <div class="col-12 col-md-6 d-flex justify-content-end align-items-center">
          <img src="j.PNG" class="rounded-circle img-fluid" style="width: 100%; height: auto;" alt="Image">
        </div>
      </div>
      <div class="mt-3">
        <a href="connexion.php" class="btn custom-btn1">Connectez-Vous</a>
        <a href="inscrire_pour_creer_club.php" class="btn custom-btn1">Inscrivez-Vous</a>
      </div>
    </div>
  </section>

  <section id="propos" class="propos_section layout_padding2-bottom mt-5 py-7">
    <div class="container">
      <img src="q.PNG" style="float: right; width: 350px">
      <h2 class="text-center" style="color: #f76b21;">Qui sommes-nous ?</h2>
      <h3 class="text-center">MyClub a pour objectif de faciliter la gestion des clubs et des évènements universitaires</h3>
      <p class="text-center" style="font-size: 25px;">L’application permet aux étudiants de s'inscrire dans un ou plusieurs clubs, de créer leur propre club, de gérer des clubs et consulter les événements universitaires de chaque club, afin de soutenir et valoriser l’engagement associatif...</p>
      <div class="text-center">
        <a href="voirplus.php" class="btn custom-btn">En savoir plus</a>
      </div>
    </div>
  </section>

  <section id="service" class="services_section layout_padding3-bottom mt-5 py-7">
    <div class="container my-5">
      <h2 class="text-center mb-4">Nos services</h2>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="service-box text-center">
            <img src="gg.PNG" class="service-img" alt="S'inscrire">
            <h5 class="title">S'inscrire à un club</h5>
            <p>Découvrez les clubs qui vous passionnent et rejoignez-les en quelques clics.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="service-box text-center">
            <img src="w.PNG" class="service-img" alt="Créer un club">
            <h5 class="title-orange">Créer un club</h5>
            <p>Lancez votre propre club, rassemblez des étudiants partageant les mêmes intérêts.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="service-box text-center">
            <img src="dd.PNG" class="service-img" alt="Découvrir les clubs">
            <h5 class="title-orange">Découvrir les Clubs existants</h5>
            <p>Explorez la liste des clubs actifs sur le campus.</p>
          </div>
        </div>
        <div class="col-md-6">
          <div class="service-box text-center">
            <img src="ff.PNG" class="service-img" alt="Événements">
            <h5 class="title-orange">Découvrir les Prochains Événements</h5>
            <p>Consultez le calendrier des événements à venir.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="club" class="club_section layout_padding3-bottom mt-3 py-5">
    <div class="container">
      <h2 class="text-center" style="color:#ff6600;">Nos clubs</h2>
      <div class="row g-4">
        <div class="col-md-6">
          <div class="club-box text-center">
            <img src="robotique.PNG" class="club-img">
          </div>
        </div>
        <div class="col-md-6">
          <div class="club-box text-center">
            <img src="it.PNG" class="club-img">
          </div>
        </div>

        </div>
      </div>
      <div class="text-center mt-3">
        <a href="voirclub.php" class="btn custom-btn4">Voir plus...</a>
      </div>
    </div>
  </section>

  <footer style="background-color:#f76b21; color:white; padding: 10px; text-align: center;">
    &copy; <?php echo date("Y"); ?> - Tous droits réservés.
  </footer>
</body>
</html>
