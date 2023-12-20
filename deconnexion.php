<?php
// Démarrez ou reprenez la session
session_start();

// Détruisez toutes les données de la session
session_destroy();

// Redirigez l'utilisateur vers la page de connexion (ou toute autre page appropriée après la déconnexion)
header("Location: index.php"); // Remplacez "login.php" par la page de connexion de votre application
exit; // Assurez-vous de terminer le script après la redirection
?>
