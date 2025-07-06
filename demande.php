<?php

try {
    $db = new PDO("mysql:host=localhost;port=3308;dbname=users;charset=utf8", "root", "");/*db variable qui contient l'objet PDO,new PDO (PHP DATA OBJECT) objet permet de se connecter a une base de donnee*/
} catch (PDOException $e) {/*exception specifier a PDO lancer si une erreur survient lors de l'interaction avec la base de donnee*/
    die("Erreur de connexion : " . $e->getMessage());/*la fct die permet d'arreter l'execution et afficher un message si la connexiona la base est echoue*/
}
?>
