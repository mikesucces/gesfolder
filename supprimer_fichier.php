<?php
if (isset($_GET['fichier'])) {
    $fichier = $_GET['fichier'];
    $cheminFichier = 'uploads/' . $fichier;

    if (file_exists($cheminFichier)) {
        // Obtenir la date du jour au format YYYY-MM-DD
        $nouveauNom = date('Y-m-d') . '_' . $fichier;
        $cheminNouveauFichier = 'uploads/' . $nouveauNom;

        // Renommer le fichier
        if (rename($cheminFichier, $cheminNouveauFichier)) {
            echo "Le fichier $fichier a été renommé en $nouveauNom avec succès.";
        } else {
            echo "Erreur lors du renommage du fichier.";
        }
    } else {
        echo "Le fichier $fichier n'existe pas.";
    }
} else {
    echo "Erreur : Paramètre manquant.";
}
?>
