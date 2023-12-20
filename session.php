<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Vérifier les informations d'identification
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Vérifier les informations d'identification dans la base de données
  if ($username == 'votre_nom_utilisateur' && $password == 'votre_mot_de_passe') {
    // Les informations d'identification sont valides
    $_SESSION['loggedin'] = true;
    header('Location: index.php');
  } else {
    // Les informations d'identification sont invalides
    $error = 'Nom d\'utilisateur ou mot de passe incorrect.';
  }
}

?>
