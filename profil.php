<?php
session_start();
require_once "bd_inscrire.php"; // utilise $db et PDO ici

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Utilisateur introuvable.");
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des données : " . $e->getMessage());
}

// Traitement de la suppression du compte
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    try {
        // Requête de suppression
        $delete_sql = "DELETE FROM users WHERE id = :id";
        $stmt = $db->prepare($delete_sql);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        // Suppression de la session et redirection
        session_destroy();
        header("Location: inscrire_pour_creer_club.php?deleted=1");
        exit();
    } catch (PDOException $e) {
        $error_message = "Erreur lors de la suppression du compte: " . $e->getMessage();
    }
}

if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['save'])){
    
        $nom=$_POST['name'];
        $email=$_POST['email'];
        $phone=$_POST['phone'];

        try{
            $stmt=$pdo->prepare("UPDATE users SET nom= :nom, email= :email, tel= :tel WHERE id= :id");
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':tel', $phone);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            echo" <script>alert('Modifications enregistrees avec succes');</script>";


        }catch(PDOException $e){
            die("Erreur lors de l'enregistrement des modifications : " . $e->getMessage());

        }


    }









?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil - Information Personnelle</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --success-color: #27ae60;
            --danger-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #34495e;
            --text-color: #333;
            --border-color: #ddd;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f5f5f5;
            color: var(--text-color);
            line-height: 1.6;
        }

        .profile-container {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background-color: #f76b21;
            color: white;
            padding: 20px;
            text-align: center;
            position: relative;
        }

        .profile-header h1 {
            font-weight: 500;
            margin-bottom: 15px;
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background-color:  #ecf0f1;
            margin: 0 auto 15px;
            overflow: hidden;
            border: 4px solid white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-nav {
            background-color: var(--dark-color);
        }

        .profile-nav ul {
            display: flex;
            list-style: none;
            overflow-x: auto;
        }

        .profile-nav li {
            flex: 1;
            min-width: 150px;
        }

        .profile-nav a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            text-align: center;
            transition: all 0.3s;
        }

        .profile-nav a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .profile-nav .active a {
            background-color:rgb(242, 144, 92) ;
            font-weight: 500;
        }

        .profile-nav i {
            margin-right: 8px;
        }

        .profile-form {
            padding: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark-color);
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: 5px;
            font-size: 16px;
            transition: border 0.3s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color:rgb(172, 98, 58) ;
            outline: none;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-save {
            background-color:rgb(172, 98, 58);
            color: white;
        }

        .btn-save:hover {
            background-color: #f76b21;
        }

        .btn-cancel {
            background-color: red;
            color: white;
        }

        .btn-cancel:hover {
            background-color: darkred;
        }

        .btn-download {
            background-color: orange;
            color: white;
            margin-left: auto;
        }

        .btn-download:hover {
            background-color:#f76b21;
        }
        .btn-supprimer{
            background-color:darkred;
            color:white;
        }
        .btn-supprimer:hover{
            background-color: red;
        }
        

        @media (max-width: 768px) {
            .profile-nav ul {
                flex-direction: column;
            }

            .profile-nav li {
                min-width: 100%;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn-download {
                margin-left: 0;
                margin-top: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <header class="profile-header">
        <i class="fas fa-user"></i>
            <h1>Mon Profil</h1>
        </header>

        <nav class="profile-nav">
            <ul>
                <li class="active"><a href="#"><i class="fas fa-user"></i> Information personnelle</a></li>
            </ul>
        </nav>

        <main class="profile-form">
            <form method="POST">
                <div class="form-group">
                    <label for="name">Nom et Prénom</label>
                    <input type="text" id="name"name="name"value="<?php echo htmlspecialchars($user['nom'] . ' ' . $user['prenom']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email"name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone"name="phone" value="<?php echo htmlspecialchars($user['tel']); ?>" required>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn btn-cancel" onclick="resetForm();">
                        <i class="fas fa-times"></i> Annuler
                    </button>
                    <button type="submit"name="save" class="btn btn-save">
                        <i class="fas fa-save"></i> Enregistrer
                    </button>
                    <a href="carte.php"><button type="button" class="btn btn-download">
                        <i class="fas fa-download"></i> Télécharger carte
                    </button></a>
                    <button type="submit" name="delete_account" class="btn btn-supprimer">
                        <i class="fas fa-times"></i> Supprimer votre compte
                    </button>
                </div>
            </form>
            
        </main>
    </div>
<script>
    function resetForm() {
    // Réinitialiser les champs du formulaire avec les valeurs d'origine
    document.getElementById("name").value = "<?php echo $user['nom'] . ' ' . $user['prenom']; ?>";
    document.getElementById("email").value = "<?php echo $user['email']; ?>";
    document.getElementById("phone").value = "<?php echo $user['tel']; ?>";
}

</script>

</body>


</html>