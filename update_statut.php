<?php
if (isset($_POST['id']) && isset($_POST['statut'])) {
    // Récupérer l'ID et le statut de la demande depuis la requête POST
    $id = $_POST['id'];
    $statut = $_POST['statut'];

    if ($statut == "Transmis") {
        // Effectuer la mise à jour du statut dans la base de données
        include('config/dbconnect.php');
        $sqlUpdate = "UPDATE demande SET statut = 'Attente' WHERE numero = $id";
        if ($connexion->query($sqlUpdate)) {
            // Répondre avec un message de succès
           // echo "Le statut a été mis à jour avec succès.";
        } else {
            // Répondre avec un message d'erreur
           /// echo "Erreur lors de la mise à jour du statut.";
        }
    } else {
        // Répondre avec un message d'erreur si le statut actuel n'est pas "Transmis"
     //   echo "Le statut actuel doit être 'Transmis' pour effectuer la mise à jour.";
    }
}
?>
