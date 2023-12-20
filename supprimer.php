<?php
// Récupération de la variable de session
session_start();
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur =  $_SESSION['user_name'];
$prenons_utilisateur =  $_SESSION['user_prename'];
$direction_utilisateur =$_SESSION['user_direction'];
$habilitation = $_SESSION['habilitation'];
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
 

// Vérifier si l'ID de la ligne à supprimer est spécifié
if(isset($_GET['id'])) {

       
    // Récupérer l'ID de la ligne à supprimer
    $id = $_GET['id'];

// Dossier des fichiers
// Dossier des fichiers
$dossierUploads = 'uploads/' . $libelleDirection . '/Attente/';

$nouveauChemin = 'uploads/' . $libelleDirection . '/';

// Recherche des fichiers commençant par l'ID sélectionné
$files = scandir($dossierUploads);

foreach ($files as $file) {
    if (strpos($file, $id . '-') === 0) {
        $nouveauNom = date('Ymd_His') . '_' . substr($file, strlen($id) + 1);
        $ancienChemin = $dossierUploads . $file;
        $nouveauChemin1 = $nouveauChemin . $nouveauNom;
        if (rename($ancienChemin, $nouveauChemin1)) {
            echo 'Le fichier ' . $file . ' a été renommé en ' . $nouveauNom . '<br>';
        } else {
            echo 'Erreur lors du renommage du fichier ' . $file . '<br>';
        }
    }
}



    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "base";
    
    $conn = new mysqli($servername, $username, $password, $database);
    if ($conn->connect_error) {
        die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }
 
  // Début de la transaction
$conn->begin_transaction();

try {
    // Suppression dans la première table
    $sql1 = "DELETE FROM document WHERE doc_demande=$id";
    $conn->query($sql1);



 // selection  dans la deuxième table
 $sql2 = "SELECT FROM demande WHERE  numero=$id";
 $conn->query($sql2);

    // Modification dans la deuxième table
    $sql3 = "UPDATE  demande SET etat='0' WHERE  numero=$id";
    $conn->query($sql3);

    // Validation de la transaction
    $conn->commit();
    //echo "Les suppressions ont été effectuées avec succès !";

   // Redirection vers la page de connexion
header('Location: demande.php');


} catch (Exception $e) {
    // En cas d'erreur, annulation de la transaction
    $conn->rollback();
    echo "Une erreur s'est produite : " . $e->getMessage();
}




// Fermeture de la connexion
$conn->close();

}
?>