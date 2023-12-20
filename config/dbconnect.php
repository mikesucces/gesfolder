<?php

// Informations de connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = "";
    $nomBaseDeDonnees = "base";

    // Création de la connexion
    $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);

    // Vérification de la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion à la base de données : " . $connexion->connect_error);
    }

    ?>