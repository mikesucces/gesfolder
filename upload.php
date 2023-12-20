<?php
session_start();
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur =  $_SESSION['user_name'];
$prenons_utilisateur =  $_SESSION['user_prename'];
$direction_utilisateur =$_SESSION['user_direction'];
$habilitation = $_SESSION['user_role'];

include('config/dbconnect.php');

// Utilisation de la variable
///echo 'Bienvenue, ' . $nom_utilisateur;

 // Suppression dans la première table
 $sqlSelect = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
 $result = $connexion->query($sqlSelect);
 
 if ($result->num_rows > 0) {
     // Récupérer la valeur du libellé
     $row = $result->fetch_assoc();
     $libelleDirection = $row['sigle'];
 

 } else {
   
 }
 
$targetDirectory = 'uploads/'; // Répertoire de destination des fichiers téléchargés
$chunkSize = 10 * 1024 * 1024; // Taille de chaque morceau (10 Mo)

// Vérifier si le fichier a été correctement envoyé
if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error'])) {
    die('Une erreur est survenue lors de la réception des fichiers.');
}

// Parcourir les fichiers envoyés
foreach ($_FILES['file']['tmp_name'] as $index => $tmpName) {
    // Vérifier si le fichier existe
    if (!is_uploaded_file($tmpName)) {
        continue;
    }

    // Ouvrir le fichier en lecture
    if (!$in = fopen($tmpName, 'rb')) {
        continue;
    }

    // Créer le fichier de destination
    $fileName = $_FILES['file']['name'][$index];
    $filePath = $targetDirectory . $fileName;
    if (!$out = fopen($filePath, 'ab')) {
        fclose($in);
        continue;
    }

    // Lire et écrire les morceaux du fichier
    while ($buff = fread($in, $chunkSize)) {
        fwrite($out, $buff);
    }

    // Fermer les fichiers
    fclose($in);
    fclose($out);

    // Supprimer le fichier temporaire
    unlink($tmpName);

    echo 'Le fichier "' . $fileName . '" a été téléchargé avec succès.';
}
