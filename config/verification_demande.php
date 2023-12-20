<?php
// Récupération de la variable de session
session_start();
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur =  $_SESSION['user_name'];
$prenons_utilisateur =  $_SESSION['user_prename'];
$direction_utilisateur =$_SESSION['user_direction'];
$habilitation =  $_SESSION['user_role'];

include('config/dbconnect.php');



 $sqlSelect = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
 $result = $connexion->query($sqlSelect);
 
 if ($result->num_rows > 0) {
     // Récupérer la valeur du libellé
     $row = $result->fetch_assoc();
     $libelleDirection = $row['sigle'];
 

 } else {
   
 }
 
 if ($habilitation='admin') {
    // Si les informations de connexion sont correctes, on crée une session et on redirige l'utilisateur vers la page d'accueil

    $_SESSION['user_id'] = $user['matricule'];
    $_SESSION['user_role'] = $user['habilitation'];
    $_SESSION['user_name'] = $user['nom'];
    $_SESSION['user_prename'] = $user['prenoms'];
    $_SESSION['user_direction'] = $user['direction_users'];
    $_SESSION['habilitation'] = $user['habilitation'];
    $_SESSION['user_username'] = $user['user_username'];
    header('Location: dashboard.php');
    exit;
} elseif ($habilitation='users') {


  $_SESSION['user_id'] = $user['matricule'];
  $_SESSION['user_role'] = $user['habilitation'];
  $_SESSION['user_name'] = $user['nom'];
  $_SESSION['user_prename'] = $user['prenoms'];
  $_SESSION['user_direction'] = $user['direction_users'];
  $_SESSION['habilitation'] = $user['habilitation'];
  $_SESSION['user_username'] = $user['user_username'];
  header('Location: demande.php');
  exit;

} else{

   // Si les informations de connexion sont incorrectes, on affiche un message d'erreur
  
   $error_message = "Erreur de Login ou mot de passe incorrect.";
}

   




 
 // Fermer la connexion à la base de données


?>