<?php
// Récupération des données envoyées par la requête AJAX
$demandeId = $_POST['demandeId'];
$validationStatus = $_POST['validationStatus'];
$comment = $_POST['comment'];

// Placez ici la logique spécifique de traitement en fonction du statut de validation/rejet
if ($validationStatus === 'Valider') {
    $updateSql = "UPDATE demande SET statut = 'Valider', date_validation = NOW(), commentaire= $comment WHERE numero = $requestId";

    if ($connexion->query($updateSql) === TRUE) {
        // La mise à jour a réussi
        echo 'La demande a été publiée avec succès.';
    } else {
        // La mise à jour a échoué
        echo 'Erreur lors de la publication de la demande : ' . $connexion->error;
    }
    $response = ['success' => true, 'message' => 'La demande a été validée avec succès.'];
} elseif ($validationStatus === 'Rejeter') {
    // Traitez le rejet de la demande, par exemple, enregistrer le commentaire de rejet
    // Vous devrez utiliser votre propre logique pour effectuer cette action
    // Assurez-vous de prendre en compte l'ID de la demande pour l'action spécifique

    // Exemple de réponse réussie
    $response = ['success' => true, 'message' => 'La demande a été rejetée avec succès.'];
} else {
    // En cas de statut non valide, renvoyez une réponse d'erreur
    $response = ['success' => false, 'message' => 'Statut de validation non valide.'];
}

// Réponse au client au format JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
