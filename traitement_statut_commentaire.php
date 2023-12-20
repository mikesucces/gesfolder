<?php
include('config/verification.php');
?>

<?php
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['user_name'];
$prenons_utilisateur = $_SESSION['user_prename'];
$direction_utilisateur = $_SESSION['user_direction'];
$statut_utilisateur = $_SESSION['user_role'];

include('config/dbconnect.php');

// ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $id = $_POST['id'];
    $fichierNom = $id;
    $nouveauStatut = $_POST['statut'];
    $commentaire = $_POST['commentaire'];
    
    $sql = "UPDATE demande SET statut = '$nouveauStatut', commentaire = '$commentaire' WHERE numero = $id";
$result = $connexion->query($sql);



// fonction mise a jour des dates

if ($result) {
    $datemaj = date("Y-m-d");
    $majdate = $nouveauStatut; // Utilisez une seule égalité (=) pour assigner la valeur

    if ($majdate == 'Valider') {
        $sqlmajdate = "UPDATE demande SET date_validation='$datemaj' WHERE numero = $id";
    } elseif ($majdate == 'Rejeter') {
        $sqlmajdate = "UPDATE demande SET date_rejet='$datemaj' WHERE numero = $id";
    } 
    $resultdate = $connexion->query($sqlmajdate);

    if (!$resultdate) {
        echo "Erreur SQL : " . $connexion->error;
    }
} else {
    echo "Erreur SQL : " . $connexion->error;
}

    
        
      // Mettre à jour le statut et le commentaire dans la base de données
   

    if ($result) {
        // La mise à jour a réussi

        // Récupérer le libellé de la direction
        $sqlSelect1 = "SELECT direction.sigle FROM demande JOIN utilisateur ON 
        demande.id_users = utilisateur.matricule JOIN direction ON 
        utilisateur.direction_users = direction.code WHERE demande.numero =$id";
        $result1 = $connexion->query($sqlSelect1);

        if ($result1->num_rows > 0) {
            $row = $result1->fetch_assoc();
            $libelleDirection = $row['sigle'];
    
            // Définir le dossier de destination en fonction du statut
            $dossierDestination = '';
    
            if ($nouveauStatut == 'Valider') {
                $dossierDestination = 'uploads/' . $libelleDirection . '/Valider';
            } elseif ($nouveauStatut == 'Rejeter') {
                $dossierDestination = 'uploads/' . $libelleDirection . '/Rejeter';
            }
    
            $fichierTrouve = true;
    
            while ($fichierTrouve) {
                // Rechercher le fichier dans le dossier Attente
                $dossierUpload = 'uploads/' . $libelleDirection . '/Attente/';
                $fichiersDansDossier = scandir($dossierUpload);
    
                $fichierTrouve = false;
    
                foreach ($fichiersDansDossier as $fichier) {
                    if (strpos($fichier, $fichierNom) === 0) {
                        $fichierDestination = $dossierUpload . $fichier;
                        $fichierTrouve = true;
    
                        // Déplacer le fichier vers le dossier de destination
                        if (rename($fichierDestination, $dossierDestination . '/' . basename($fichierDestination))) {
                            // Succès : le fichier a été déplacé avec succès
                        } else {
                            echo "Une erreur s'est produite lors du déplacement du fichier.";
                            exit();
                        }
    
                        break;
                    }
                }
            }
    
           // echo "La demande a été mise à jour avec succès.";
        } else {
          //  echo "Aucun libellé de direction n'a été trouvé.";
        }
    } else {
        //echo "Une erreur s'est produite lors de la mise à jour de la demande.";
    }
}
?>
<style>

    body {
        background-image: url('fond.jpg'); background-size: cover;  background-repeat: no-repeat;
    }
</style>
<?php
include('header&footer/header_acceuil.php');

?>

<main class="container">
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4"><b>Détails de la demande</b></h1>

                <div class="alert alert-success" role="alert">
                    Les modifications ont été enregistrées avec succès.
                    <br>
                    <a href="demande.php">Revenir à la page de demande</a>
                </div>

                <!-- Le reste du contenu de la page -->

            </div>
        </div>
    </div>
</main>

<?php
include('header&footer/footer.php');
?>
