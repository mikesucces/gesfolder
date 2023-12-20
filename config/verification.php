<?php
// secure.php

// Vérification de la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Rediriger vers la page de connexion
    header("Location: index.php");
    exit;
}

// Récupération des variables de session
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['user_name'];
$prenons_utilisateur = $_SESSION['user_prename'];
$direction_utilisateur = $_SESSION['user_direction'];
$habilitation = $_SESSION['user_role'];

include('config/dbconnect.php');

// Utilisation de la variable
// echo 'Bienvenue, ' . $nom_utilisateur;

// Suppression dans la première table
$sqlSelect = "SELECT sigle FROM direction WHERE code = ?";
$stmt = $connexion->prepare($sqlSelect);

if ($stmt) {
    // Associer la valeur à la requête préparée
    $stmt->bind_param("i", $direction_utilisateur);

    // Exécuter la requête
    $stmt->execute();

    // Obtenir le résultat
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Récupérer la valeur du libellé
        $row = $result->fetch_assoc();
        $libelleDirection = $row['sigle'];
    } else {
        // Traitement en cas d'absence de résultat
    }

    // Fermer la requête préparée
    $stmt->close();
}

// Fermer la connexion à la base de données
$connexion->close();

// ...
?>
