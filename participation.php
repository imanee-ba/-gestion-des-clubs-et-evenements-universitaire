<?php
require_once'bd_inscrire.php';
if($_SERVER["REQUEST_METHOD"] =="POST" ){
    $nom=$_POST['nom'];
    $prenom=$_POST['prenom'];
    $filiere=$_POST['filiere'];
   
    $email=$_POST['email'];

   $sql="INSERT INTO participer (nom,prenom,filiere,email) 
   VALUES (?, ?, ?, ?)";
   $stmt=$db->prepare($sql);
   $result=$stmt->execute([$nom, $prenom,$filiere,$email]);
   if($result){
    echo "✅ Participation réussie ! ";
   } else{
    echo "❌ une erreur est survenue .";
   }
}
?>


