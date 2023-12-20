<?php
include('config/verification.php');
?>

<?php
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur =  $_SESSION['user_name'];
$prenons_utilisateur =  $_SESSION['user_prename'];
$direction_utilisateur =$_SESSION['user_direction'];
$statut_utilisateur=$_SESSION['role'];


include('config/dbconnect.php');


 $sqlSelect = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
 $result = $connexion->query($sqlSelect);
 
 if ($result->num_rows > 0) {
     // Récupérer la valeur du libellé
     $row = $result->fetch_assoc();
     $libelleDirection = $row['sigle'];
 

 } else {
   
 }
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


          $sql = "SELECT * FROM demande where numero=$id";
          $res = $connexion->query($sql);
          $statut = $res->fetch_assoc();
        
          $role=$statut['statut'];

          // Récupérer les détails de la demande à partir de la source de données
          $demande = // Récupérer les détails de la demande en utilisant l'identifiant

          // Récupérer la liste des fichiers liés existants pour la demande
          $searchTerm = $id . '-';
          $files = glob('uploads/' . $libelleDirection . '/Attente/*' . $searchTerm . '*');
                     
          // Afficher la liste des fichiers liés existants
         if ($role='users'){
          if (!empty($files)) {
            echo '<table class="table">';
            echo '<thead>';
            echo '<tr>';
            echo '<th>N° Ordre</th>';
            echo '<th>Nom du fichier</th>';
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
              echo '<td><a href="' . $documentUrl . '" target="_blank"><i class="fa fa-file" title="voir le document"></i></a></td>';


              echo '</tr>';

              $numeration++; // Incrémenter la numérotation
            }

            echo '</tbody>';
            echo '</table>';
          } else {
            echo "Aucun fichier lié trouvé pour cette demande.";
          }

          echo '<div></div>';

          // Formulaire d'ajout de fichiers
          echo '<form action="ajouter_fichier.php" method="post" enctype="multipart/form-data">';
          echo '<input type="hidden" name="id" value="' . $id . '">';

          echo '<div class="form-group">';
          echo '<label for="statut">Statut :</label>';
          echo '<select class="form-control" name="statut">';
          echo '<option value="En traitement">En traitement</option>';
          echo '<option value="Valider">Valider</option>';
          echo '<option value="Rejeter">Rejeter</option>';
          echo '</select>';
          echo '</div>';

          echo '<div class="form-group">';
          echo '<label for="commentaire">Commentaire :</label>';
          echo '<textarea class="form-control" name="commentaire"></textarea>';
          echo '</div>';

          echo '<div></div>';
          echo '<div>';
          
          
          echo'</div>';
          echo '<div></div>';

          echo '<button type="submit" class="btn btn-primary d-block mx-auto">Ajouter</button>';

          echo '<a href="demande.php?id=<?php echo $id; ?>" class="btn btn-secondary mt-3">Retour à la demande</a>';
          echo '</form>';
        }
    }
    
        ?>
      </div>
    </div>
  </div>
</main>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<!-- Ajoutez ce code dans la section <head> de votre page HTML -->

<?php
include('header&footer/footer.php');
?>