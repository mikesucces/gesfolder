<?php
// Inclure la configuration de la base de données et établir la connexion
include('config/dbconnect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['requestId'])) {
    $requestId = $_POST['requestId'];

    // Mettez à jour le statut de la demande dans la base de données
    $updateSql = "UPDATE demande SET statut = 'Publier', date_publication = NOW() WHERE numero = $requestId";

    if ($connexion->query($updateSql) === TRUE) {
        // La mise à jour a réussi
        echo 'La demande a été publiée avec succès.';
    } else {
        // La mise à jour a échoué
        echo 'Erreur lors de la publication de la demande : ' . $connexion->error;
    }

    // Fermeture de la connexion à la base de données
    $connexion->close();
} else {
    // Requête non valide
    echo 'Requête non valide.';
}
?>
