<?php

include('config/dbconnect.php');

?>

      <?php
   if (isset($_GET['id']) && isset($_GET['statut'])) {
    $id = $_GET['id'];
    $statut = $_GET['statut'];


    // Mettre à jour le statut et la date en_traitement dans la base de données
    $sqlUpdate = "UPDATE demande SET statut = ? WHERE numero = ?";
    $stmt = $connexion->prepare($sqlUpdate);
    $stmt->bind_param("si", $statut, $id); // Utilisation de "sss" pour les trois valeurs de type chaîne
    if ($stmt->execute()) {
     //   echo "Mise à jour réussie.";
    } else {
     //   echo "Erreur lors de la mise à jour : " . $stmt->error;
    }

    $stmt->close();
}

// Fermez la connexion à la base de données à la fin du script
$connexion->close();
?>


      

<?php
include('config/verification.php');
?>

<?php
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur =  $_SESSION['user_name'];
$prenons_utilisateur =  $_SESSION['user_prename'];
$direction_utilisateur =$_SESSION['user_direction'];
$statut_utilisateur=$_SESSION['user_role'];


include('config/dbconnect.php');





$sqlSelect = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
$result = $connexion->query($sqlSelect);

if ($result->num_rows > 0) {
    // Récupérer la valeur du libellé
    $row = $result->fetch_assoc();
    $libelleDirection = $row['sigle'];
} else {
   
}
?>
<style>
    main {
         /* Couleur de fond blanche pour le contenu */
        //* Marge intérieure pour l'espace autour du contenu */
        
        background-image: url('fond.jpg'); background-size: cover;  background-repeat: no-repeat;
    }

    .custom-form-container {
        /* Couleur de fond grise */
       /* border: 3px solid white; /* Bordure grise */
        padding: 0px; /* Marge intérieure pour l'espace autour du contenu */
        border-radius: 5px; /* Coins arrondis */
        margin-top: -35px;
        margin-bottom: 10px;
        
    }
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

                <?php
                if (isset($_GET['id'])) {
                    // Récupérer l'identifiant de la demande à modifier
                    $id = $_GET['id'];

                    // Mise à jour du statut
              

                    $sql = "SELECT * FROM demande WHERE numero=$id";
                    $res = $connexion->query($sql);
                    $demande = $res->fetch_assoc();
                    $demandeStatut = $demande['statut'];
                    $com = $demande['commentaire'];
                    $nat = $demande['nature'];
                    $lib= $demande['libelle'];
                    $ins = $demande['instruction'];
                    $da = $demande['date'];
                    $de = $demande['delai'];
                    $ref = $demande['reference'];
                    $date_pub=$demande['date_publication'];
                    $date_re=$demande['date_rejet'];

                    // Récupérer la liste des fichiers liés existants pour la demande
                    $searchTerm = $id . '-';
                    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator('uploads'));
                    $files = [];

                    foreach ($iterator as $file) {
                        if ($file->isFile()) {
                            $filename = $file->getFilename();
                            if (strpos($filename, $searchTerm) !== false) {
                                $files[] = $file->getPathname();
                            }
                        }
                    }
                    echo'<div>&nbsp</div>';
                    echo '<div class="custom-form-container">';

                  
                    echo'<div>';
                    echo '<label for="nature"><b>REFERENCE</b> : ' . $ref . '</label><br/>';
                    echo '<label for="nature"><b>NATURE</b> : ' . $nat . '</label><br/>';
                    '</div>';
                  
                    echo'<div>';
                    echo '<label for="objet"><b>OBJET</b> : ' . $lib . '</label><br/>';
                    echo '<label for="instruction"><b>DETAILS DE LA DEMANDE</b> : ' . $ins . '</label><br/>';
                    '</div>';
                   
                    echo'<div>';
                    echo '<label for="date"><b>DATE</b> : '. date("d-m-Y", strtotime($da)) . '</label><br/>';
                    echo '<label for="delai"><b>DELAI</b> : '. date("d-m-Y", strtotime($de)) . '</label><br/>';
                    '</div>';
                   
                    
                
                    if($demandeStatut==='Publier'){ echo '<label for="date_p"><b>DATE DE PUBLICATION</b> : '. date("d-m-Y", strtotime($date_pub)) . '</label><br/>';}
                    if($demandeStatut==='Rejeter'){ echo '<label for="date_p"><b>DEATE DE REJET</b> : '. date("d-m-Y", strtotime($date_re)) . '</label><br/>';}
       
                    
        
                         echo'<div>&nbsp</div>';
                       echo '</div>';
                    // Afficher la liste des fichiers liés existants
                    if (!empty($files)) {
                        echo '<table class="table">';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>N°</th>';
                        echo '<th>Nom</th>';
                        echo '<th>Fichier</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        $numeration = 1; // Numérotation initiale

                        foreach ($files as $file) {
                            $filename = basename($file);
                            $fileStatus = ''; // Statut du fichier (vide par défaut)
                            $fileExtension = pathinfo($filename, PATHINFO_EXTENSION);
                            $fileLink = '';
                            $documentUrl = $file;

                            echo '<tr>';
                            echo '<td>' . $numeration . '</td>'; // Numérotation
                            echo '<td>' . $filename . '</td>';


 // Afficher le lien avec l'icône et la couleur correspondantes

                            // Obtenir l'extension du fichier
                            $extension = pathinfo($documentUrl, PATHINFO_EXTENSION);

                            // Déterminer l'icône et la couleur en fonction de l'extension du fichier
                            $icone = '';
                            $couleur = '';
                            if (in_array($extension, ['doc', 'docx'])) {
                                $icone = '<i class="fas fa-file-word"></i>'; // Icône Word
                                $couleur = 'blue'; // Couleur pour les fichiers Word
                            } elseif (in_array($extension, ['xls', 'xlsx'])) {
                                $icone = '<i class="fas fa-file-excel"></i>'; // Icône Excel
                                $couleur = 'green'; // Couleur pour les fichiers Excel
                            } elseif (in_array($extension, ['pdf'])) {
                                $icone = '<i class="fas fa-file-pdf"></i>'; // Icône PDF
                                $couleur = 'red'; // Couleur pour les fichiers PDF
                            } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                                $icone = '<i class="fas fa-file-image"></i>'; // Icône Image
                                $couleur = 'orange'; // Couleur pour les fichiers image
                            } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', '3gp', 'm4v', 'mpeg', 'mpg', 'ogg'])) {
                                $icone = '<i class="fas fa-file-video"></i>'; // Icône Vidéo
                                $couleur = 'purple'; // Couleur pour les fichiers vidéo
                            } elseif (in_array($extension, ['mp3', 'wav', 'wma', 'aac', 'flac', 'alac', 'm4a'])) {
                                $icone = '<i class="fas fa-file-audio"></i>'; // Icône Audio
                                $couleur = 'yellow'; // Couleur pour les fichiers audio
                            } else {
                                $icone = '<i class="fas fa-file"></i>'; // Icône par défaut pour les autres types de fichiers
                                $couleur = 'gray'; // Couleur par défaut pour les autres types de fichiers
                            }
                            
                            echo '<td><a href="' . $documentUrl . '" target="_blank" style="color: ' . $couleur . ';">' . $icone . '</a></td>';


                          //  echo '<td><a href="' . $documentUrl . '" target="_blank"><i class="fa fa-file" title="voir le document"></i></a></td>';


                          //fin du code pour afficher le fichier 
                            echo '</tr>';

                            $numeration++; // Incrémenter la numérotation
                        }

                        echo '</tbody>';
                        echo '</table>';
                    } else {
                        echo "Aucun fichier pour cette demande.";
                    }

                    echo '<div></div>';

                    // Formulaire d'ajout de fichiers
                    echo '<form action="traitement_statut_commentaire.php" method="post" enctype="multipart/form-data" id="modifier-form">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';
                 
                    echo '<div class="form-group">';
                    echo '<label for="statut">DECISION :</label>';
                    
                    
                    if (($demandeStatut === "Attente" ) && ($statut_utilisateur !== 'admin')) {
                   
                        echo '<select class="form-control" name="statut">';
                        echo '<option value="" selected></option>'; // Option vide sélectionnée
                       
                       if($demandeStatut !== "Valider" ){
                        echo '<option value="Valider">A publier</option>';
                        echo '<option value="Rejeter">Rejeter</option>';
                       }
                       else{
                        echo '<option value="Publier">Publier</option>';

                       }

                        
                        echo '</select>';
                       
                        
                    } 
                    
                    else {
                        echo '<input type="text" class="form-control" value="' . $demandeStatut . '" readonly>';
                    }
                    


                    echo '</div>';
                    

                    echo '<div class="form-group">';
                    echo '<label for="commentaire">Commentaire :</label>';
                    
                    if (($demandeStatut === "Attente" ) && ( $statut_utilisateur !== 'admin')) {
                        echo '<textarea class="form-control" name="commentaire"></textarea>';
                    } else {
                        echo '<textarea class="form-control" name="commentaire" readonly>' . $com . '</textarea>';
                    }
                    
                    echo '</div>';

                    echo '<div></div>';
                    echo '<div>';
                    echo '</div>';
                    echo '<div></div>';

                    if (($demandeStatut === "Attente" ) && (  $statut_utilisateur !== 'admin')) {
                        echo '<div class="form-group mt-4">';
                        echo '<button type="submit" class="btn btn-primary d-block mx-auto" onmouseover="this.style.color=\'white\';" onmouseout="this.style.color=\'\';">Valider</button>';
                        echo '</div>';
                    }

                    echo '<a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn btn-secondary mt-3">Retour à la demande</a>';

                    echo '</form>';
                }
                ?>
            </div>
        </div>
    </div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="js/script.js"></script>


<!-- Ajoutez ce code dans la section <head> de votre page HTML -->

<?php
include('header&footer/footer.php');
?>



 <!-- CODE D'ENREGISTREMENT DE LA DEMANDE   -->
 <script>
// Attendez que le DOM soit chargé
$(document).ready(function () {
    // Associez la fonction soumettreFormulaire à l'événement de soumission du formulaire
    $('#modifier-form').submit(soumettreFormulaire);
});

// Fonction pour soumettre le formulaire
function soumettreFormulaire(event) {
    // Empêcher le formulaire de se soumettre normalement
    event.preventDefault();

    // Créer un objet FormData pour envoyer les données du formulaire (y compris les fichiers)
    var formData = new FormData($('#modifier-form')[0]);

    // Effectuer une requête AJAX POST pour envoyer les données au serveur
    $.ajax({
        type: 'POST',
        url: 'traitement_statut_commentaire.php', // L'URL du script PHP qui traitera les données
        data: formData,
        contentType: false, // Nécessaire lorsque vous utilisez FormData
        processData: false, // Nécessaire lorsque vous utilisez FormData
        success: function (response) {
            // La requête a réussi, vous pouvez afficher la réponse ici
            // Vous pouvez également afficher une boîte de dialogue SweetAlert pour afficher un message
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: 'Enregistrement validé.'
            });

       //  recharger la page
       setTimeout(function () {
        window.location.href = 'demande.php';
    }, 2000);

            // Vous pouvez également réinitialiser le formulaire si nécessaire
            $('#modifier-form')[0].reset();
        },
        error: function (error) {
            // La requête a échoué, vous pouvez gérer les erreurs ici
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Une erreur s\'est produite lors de l\'enregistrement.'
            });
        }
    });
}


</script>


