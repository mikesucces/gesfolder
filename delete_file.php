<?php
// Récupérer le nom du fichier à supprimer
$filename = $_POST['filename'];

// Supprimer le fichier
if (unlink($filename)) {
    // Réponse de réussite
    http_response_code(200);
    echo "Le fichier a été supprimé.";
} else {
    // Réponse d'échec
    http_response_code(500);
    echo "Une erreur s'est produite lors de la suppression du fichier.";
}
?>
