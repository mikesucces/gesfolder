<?php

include('config/verification.php');
include('config/dbconnect.php');



  /// fonction pour achever le processus  
if (isset($_GET['id']) && isset($_GET['statut'])) {
    $id = $_GET['id'];
    $statut = $_GET['statut'];

    
    $etat = '4';

      if (($statut==='Publier')||($statut==='Rejeter')){
    // Mettre à jour le statut et la date en_traitement dans la base de données
    $sqlUpdate = "UPDATE demande SET etat = ? WHERE numero = ?";
    $stmt = $connexion->prepare($sqlUpdate);
    $stmt->bind_param("si", $etat, $id); // Utilisation de "sss" pour les trois valeurs de type chaîne

    if ($stmt->execute()) {
     //   echo "Mise à jour réussie.";
    } else {
     //   echo "Erreur lors de la mise à jour : " . $stmt->error;
    }
}
    //$stmt->close();
}

// Fermez la connexion à la base de données à la fin du script







$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['user_name'];
$prenons_utilisateur = $_SESSION['user_prename'];
$direction_utilisateur = $_SESSION['user_direction'];
$statut_utilisateur = $_SESSION['user_role'];



$sqlSelect = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
$result = $connexion->query($sqlSelect);

if ($result->num_rows > 0) {
    // Récupérer la valeur du libellé
    $row = $result->fetch_assoc();
    $libelleDirection = $row['sigle'];
} else {
    // Gérer le cas où aucun résultat n'est retourné
    $libelleDirection = '';
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

                    $sql = "SELECT * FROM demande WHERE numero=$id";
                    $res = $connexion->query($sql);
                    $statut = $res->fetch_assoc();
                    $role = $statut['statut'];
                    $commentaire = $statut['commentaire'];
                    $libelle=$statut['libelle']; 
                     $instruction=$statut['instruction'];
                     $nature=$statut['nature'];
                     $date=$statut['date'];
                     $delai=$statut['delai'];
                     $reference=$statut['reference'];
                     $date_pub=$statut['date_publication'];
                     $date_re=$statut['date_rejet'];

                    // Récupérer les détails de la demande à partir de la source de données
                    $demande = // Récupérer les détails de la demande en utilisant l'identifiant

                    // Récupérer la liste des fichiers liés existants pour la demande
                    $searchTerm = $id . '-';

                    if ($role==='Enregistrer'|| $role==='Attente' || $role==='Transmis'){
                        $files = glob('uploads/' . $libelleDirection . '/Attente/*' . $searchTerm . '*');
                    }
                   
                    elseif ($role==='Valider' || $role==='Publier'){
                        $files = glob('uploads/' . $libelleDirection . '/Valider/*' . $searchTerm . '*');
                    }
                    else{
                        $files = glob('uploads/' . $libelleDirection . '/Rejeter/*' . $searchTerm . '*');
                    }
                    echo'<div ">&nbsp</div>';
                    echo '<div class="custom-form-container">';
                    echo '<label for="nature"><b>REFERENCE</b> : ' . $reference . '</label><br/>';
                    echo'<div>&nbsp</div>';
                    echo '<label for="nature"><b>NATURE</b> : ' . $nature . '</label><br/>';
                    echo'<div>&nbsp</div>';
                    echo '<label for="objet"><b>OBJET</b> : ' . $libelle . '</label><br/>';
                    echo'<div>&nbsp</div>';
                    echo '<label for="instruction"><b>DETAILS DE LA DEMANDE</b> : ' . $instruction . '</label><br/>';
                    echo'<div>&nbsp</div>';
                    echo '<label for="date"><b>DATE</b> : '. date("d-m-Y", strtotime($date)) . '</label><br/>';
                    echo'<div>&nbsp</div>';
                    echo '<label for="delai"><b>DELAI D\'EXECUTION</b> : '. date("d-m-Y", strtotime($delai)) . '</label><br/><br/>';
                    
                 //   $cheminFichierPDF = 'uploads/' . $libelleDirection . '/' . $reference . '.pdf';

                    // Vérifier si le fichier PDF existe
                   // if (file_exists($cheminFichierPDF)) {
                        // Le fichier PDF existe, nous pouvons afficher l'icône et le lien
                    //    $icone = '<i class="fas fa-file-pdf"></i>'; // Icône PDF (à personnaliser selon vos besoins)
                      //  $lienPDF = $cheminFichierPDF; // Lien vers le fichier PDF
                    
                     //   echo '<td>' . $icone . '  <a href="' . $lienPDF . '" target="_blank">Voir le PDF</a></td>';
                   // } else {
                        // Le fichier PDF n'existe pas
                    //    echo '<td>Aucun PDF disponible pour cette référence</td>';
                   // }


                    if($role==='Publier'){ echo '<label for="date_p"><b>DATE DE PUBLICATION</b> : '. date("d-m-Y", strtotime($date_pub)) . '</label><br/>';}
                    if($role==='Rejeter'){ echo '<label for="date_p"><b>DEATE DE REJET</b> : '. date("d-m-Y", strtotime($date_re)) . '</label><br/>';}
                  
                    echo'<div>&nbsp</div>'; 
       

                    
                    if ($role == 'Attente') {
                        echo '<label for="statut"><b>STATUT</b> : En traitement</label>';
                       /// echo '<input type="text" name="statut" value="" readonly class="form-control">';
                    } else {
                        echo '<label for="statut"><b>DECISION</b> : ' . $role . '</label>';
                      //  echo '<input type="text" name="statut" value="' . $role . '" readonly class="form-control">';
                    }                   
                    echo'<div>&nbsp</div>';
                   
                           if ($role === 'Valider' || $role === 'Rejeter') {
                             echo '<div class="form-group">';
                             echo '<label for="commentaire"><b>JUSTIFICATION</b> : ' . $commentaire . '</label>';
                            // echo '<textarea class="form-control" name="commentaire" readonly></textarea>';
                             echo '</div>';
                         }
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

                            echo '<tr id="fileRow' . $numeration . '">';
                            echo '<td>' . $numeration . '</td>'; // Numérotation
                            echo '<td>' . $filename . '</td>';



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

                            // Afficher le lien avec l'icône et la couleur correspondantes
                            echo '<td><a href="' . $documentUrl . '" target="_blank" style="color: ' . $couleur . ';">' . $icone . '</a></td>';


                            
                           // echo '<td><a href="' . $documentUrl . '" target="_blank"><i class="fa fa-file" title="voir le document"></i></a></td>';         
                            
                            if ($role === 'Enregistrer') {
                                echo '<td><a href="javascript:void(0);" onclick="deleteFile(\'' . $file . '\', \'fileRow' . $numeration . '\')"><i class="fas fa-trash-alt"></i></a></td>';
                            }
                            
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
                    echo '<form action="ajouter_fichier.php" method="post" enctype="multipart/form-data">';
                    echo '<input type="hidden" name="id" value="' . $id . '">';


?>
    <!-- SCRIPT POUR VERIFIER LES FICHIERS   -->
    <script>
                function validateFiles() {
                    var input = document.getElementById('fileInput');
                    var files = input.files;
            
                    for (var i = 0; i < files.length; i++) {
                        var file = files[i];
                        var fileSize = file.size;
                        var maxSize = 10 * 1024 * 1024 * 1024; // 10 GB
            
                        if (fileSize > maxSize) {
                            alert('La taille du fichier "' + file.name + '" dépasse la limite de 10 Mo.');
                            return false;
                        }
            
                        var allowedExtensions = ['.doc', '.docx', '.xls', '.xlsx', '.pdf', '.jpg', '.jpeg', '.png', '.gif', '.mp3', '.mp4', '.avi', '.mov', '.wmv', '.flv', '.mkv', '.webm', '.3gp', '.m4v', '.mpeg', '.mpg', '.ogg', '.wav', '.wma', '.aac', '.flac', '.ogg', '.alac', '.m4a', '.bmp', '.webp', '.svg', '.tiff'];
            var fileExtension = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes('.' + fileExtension)) {
                alert('Le fichier "' + file.name + '" a une extension non conforme. Les extensions autorisées sont : .doc, .docx, .xls, .xlsx, .pdf, .jpg, .jpeg, .png, .gif');
                return false;
            }
        }
            
                    return true;
                }
            </script>

    <!-- SCRIPT POUR LISTER LES FICHIERS   -->
<script>

document.querySelector('input[name="file[]"]').addEventListener('change', function (event) {
    var files1 = event.target.files;
    var fileList1 = "";

    for (var i = 0; i < files1.length; i++) {
        fileList1 += files1[i].name + "<br>";
    }

    document.getElementById('fileList1').innerHTML = fileList1;
});
</script>

    <div id="fileList1">
    </div>
<?php


                   
                    echo '<div class="form-group">';
                    echo '<a href="' . $_SERVER['HTTP_REFERER'] . '" class="btn btn-secondary mt-3">Retour à la demande</a>';
                    echo '</div>';

                    echo '</form>';
                }
                ?>
            </div>
        </div>
    </div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    function deleteFile(filename, rowId) {
        if (confirm("Êtes-vous sûr de vouloir supprimer ce fichier ?")) {
            // Envoyer une requête AJAX pour supprimer le fichier
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete_file.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Le fichier a été supprimé avec succès
                    alert("Le fichier a été supprimé.");
                    // Supprimer la ligne correspondante du tableau
                    var row = document.getElementById(rowId);
                    row.parentNode.removeChild(row);
                } else {
                    console.error("Une erreur s'est produite lors de la suppression du fichier :", xhr.responseText);
                }
            };
            xhr.send('filename=' + encodeURIComponent(filename));
        }
    }
</script>



    <!-- SCRIPT POUR AFFICHER LE NOM DES FICHIERS SELECTIONNER   -->

<!-- Ajoutez ce code dans la section <head> de votre page HTML -->
<?php
include('header&footer/footer.php');
?>


<script src="js/script.js"></script>
