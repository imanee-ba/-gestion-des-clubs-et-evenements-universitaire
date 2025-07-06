<?php

try{
    $db=new PDO("mysql:host=localhost;port=3308;dbname=users;charset=utf8","root","");

}catch(PDOException $e){
    dir("Erreur de connexion :" . $e->getMessage());
}
?>