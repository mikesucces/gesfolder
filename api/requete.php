<?php 
include('config/dbconnect.php');

/// DEBUT AUTHENTIFICATION///

// Variables de connexion (remplacez-les par vos valeurs)


// Requête SQL pour vérifier les informations de connexion
$query = "SELECT * FROM Utilisateur WHERE username=? AND password=?";
$stmt = $connexion->prepare($query);
$stmt->bind_param("ss", $login, $password);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user) {
    // Si les informations de connexion sont correctes, on crée une session et on redirige l'utilisateur vers la page d'accueil
    session_start();
    $_SESSION['user_id'] = $user['matricule'];
    $_SESSION['user_role'] = $user['habilitation'];
    $_SESSION['user_name'] = $user['nom'];
    $_SESSION['user_prename'] = $user['prenoms'];
    $_SESSION['user_direction'] = $user['direction_users'];
    $_SESSION['user_role'] = $user['habilitation'];

    // Après la validation des informations d'identification
// et la création de la session, définir la variable de session
$_SESSION['loggedin'] = true;


    // Redirection vers la page demande.php
    header("Location: demande.php");
    $connexion_reussie = true;

$_POST['username']="";
$_POST['password']="";

    exit();
} else {
    // Si les informations de connexion sont incorrectes, on affiche un message d'erreur
    $error_message = '<div class="alert alert-danger" align="center" role="alert">Login ou mot de passe incorrect.</div>';
    $loginError = true;
    $passwordError = true;
    $connexion_reussie = false;
}
/// FIN ///


/// REQUETE DIRECTION AGENT ///
$req_direction_agent = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
$result = $connexion->query($req_direction_agent);


if ($result->num_rows > 0) {
    // Récupérer la valeur du libellé
    $row = $result->fetch_assoc();
    $libelleDirection = $row['sigle'];

} else {
  
}

/// FIN///


///    PROCESUS INSERTION D'UNE DEMANDE //





// Générez la nouvelle référence




///FIN///



























?>