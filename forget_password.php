<?php
require_once"bd_inscrire.php";
session_start();
$message="";
if($_SERVER['REQUEST_METHOD']=== 'POST' && isset($_POST['verifier'])){
    $nom=trim($_POST['nom']);
    $filiere=trim($_POST['filiere']);
    $email=trim($_POST['email']);
    $tele=trim($_POST['tele']);
    
}



?>