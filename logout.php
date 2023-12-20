<?php
// Démarrez la session
session_start();

// Détruisez toutes les données associées à la session
session_destroy();

// Redirigez l'utilisateur vers la page de connexion
header("Location: index.php");
exit();
?>
