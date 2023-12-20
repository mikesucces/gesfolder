<?php
include('config/verification.php');
include('header&footer/header_acceuil.php');
include('config/dbconnect.php');

?>
<style>
     body {
        margin: 0; /* Supprimez les marges par défaut du corps */
        
        background-image: url('fond.jpg');
         background-size: cover; 
          background-repeat: no-repeat;
    }

    main {
        margin-top: 0; /* Réduisez la marge supérieure de l'élément <main> à zéro */
    }

    .col-md-6.border.border-3.border-primary.rounded.p-3 {
    border-color: white !important;
  }
    
</style>
<main class="container"style="">
<?php if ($habilitation =='users'): ?>

    <!-- Formulaire de demande de publication -->
    <div class="mb-2 text-center p-3">
    <h1 class="mb-3">FORMULAIRE DE DEMANDE</h1>
    <form action="demande_process.php" method="post" enctype="multipart/form-data">
        <div class="mb-3 row" >
            <div class="col-md-3"></div> <!-- Colonne vide à gauche -->
            
            <div class="col-md-6 border border-3 border-primary rounded p-3" > <!-- Colonnes centrales avec bordure et espace intérieur -->
            <div class="mb-3 row">
    <div class="col-md-6">
    
    <select name="nature" id="nature" class="form-control">
    <option value="">Sélectionnez la nature de la demande</option>
    <option value="PUBLICATION">PUBLICATION</option>
    <option value="RETRAIT">RETRAIT</option>
</select>


    </div>
    <div class="col-md-6">
      
        <input type="text" class="form-control form-control-sm" id="libelle" name="libelle" placeholder="Objet" required>
    </div>
</div>

<div class="mb-3 row">
    <div class="col-md-6">
    <!--  Dans la date j'ai retirer les jours avant la date systeme et les weekends  -->
    <input type="date" class="form-control form-control-sm" id="delai" name="delai" required placeholder="Délai d'exécution" min="<?php echo date('Y-m-d'); ?>" oninput="validateDate(this)">
    <small class="form-text text-muted">Délai d'exécution</small>

    </div>
    <div class="col-md-6">
      
    <input type="file" class="form-control" id="fileInput" name="file[]" accept=".mp4,.avi,.mov,.wmv,.flv,.mkv,.webm,.3gp,.m4v,.mpeg,.mpg,.ogg,.mp3,.wav,.wma,.aac,.flac,.ogg,.alac,.m4a,.jpg,.jpeg,.png,.gif,.bmp,.webp,.svg,.tiff" multiple />
                    <small class="form-text text-muted">Taille maximale des fichiers : 1 Go.</small>
    </div>

    <textarea rows="4" class="form-control form-control-sm" id="instruction" name="instruction" placeholder="Détails" required></textarea>

</div>

                <div class="mb-3">
                </div>

                <div class="text-center">
                <input type="hidden" name="numero" id="numero" />
      <input type="hidden" name="date" id="date" />
      <input type="hidden" name="commentaire" id="commentaire" />
      <input type="hidden" name="statut" id="statut" />
      <input type="hidden" name="statut1" id="$libelleDirection" />
     
                    <button onclick="return validateFiles();" type="submit" class="btn btn-primary btn-lg" onmouseover="this.style.color='white'" onmouseout="this.style.color=''">Transmettre</button>
                </div>
            </div>

            <div class="col-md-3"></div> <!-- Colonne vide à droite -->
        </div>
    </form>
</div>

<?php endif; ?>




<?php if ($habilitation !== 'users'): ?>
<h1 class="text-center mb-3">LISTE DE DEMANDES</h1>
<?php endif; ?>
    <div class="row justify-content-center">
        <table id="myTable" class="table table-bordered;  border-collapse: collapse; width: 100%;">
            <!-- Insérez ici le code HTML pour le tableau -->
            <thead>
                <!-- Entêtes de colonnes -->
                <tr>

                </tr>
            </thead>
            <tbody>
            <?php
  if ($habilitation =='users'){ include('tableau.php');}
   elseif ($habilitation !=='users'){ include('dashboard_table.php');}
   else{}
?>

            </tbody>
        </table>
        <!-- PAGINATION   -->

<div class="pagination justify-content-end text-right">
<?php
    // Affichage du bouton "Début" s'il y a plus d'une page
    if ($currentPage > 1) {
        echo "<a href='demande.php?page=1'>&laquo;</a>&nbsp;";
    }

    // Affichage du bouton "Précédent" s'il y a une page précédente
    if ($currentPage > 1) {
        $previousPage = $currentPage - 1;
        echo "<a href='demande.php?page=$previousPage'>&lsaquo;</a>&nbsp;";
    }

    // Affichage de l'élément "Page" avant les numéros de page
    echo "<span>Page : </span>&nbsp;";

    // Affichage des numéros de page
    for ($page = 1; $page <= $totalPages; $page++) {
        if ($page == $currentPage) {
            echo "<span class='current-page'>$page</span>&nbsp;"; // Numéro de page actuel
        } else {
            echo "<a href='demande.php?page=$page'>$page</a>&nbsp;"; // Autres numéros de page
        }
    }

    // Affichage du bouton "Suivant" s'il y a une page suivante
    if ($currentPage < $totalPages) {
        $nextPage = $currentPage + 1;
        echo "<a href='demande.php?page=$nextPage'>&rsaquo;</a>&nbsp;";
    }

    // Affichage du bouton "Fin" s'il y a plus d'une page
    if ($currentPage < $totalPages) {
        echo "<a href='demande.php?page=$totalPages'>&raquo;</a>";
    }
?>

    </div>
</main>

<?php
include('header&footer/footer.php');
?>

<script script src="https:js/coran.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script>
    // Votre code JavaScript pour la recherche dans le tableau va ici
    $(document).ready(function() {
        $('#searchInput').keyup(function() {
            var value = $(this).val().toLowerCase();
            $('#myTable tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>

<!-- Script retrait des weekend dans le delai -->
<script>
function validateDate(input) {
    // Récupérer la date sélectionnée
    var selectedDate = new Date(input.value);
    
    // Vérifier si la date sélectionnée est un samedi (jour de la semaine 6) ou un dimanche (jour de la semaine 0)
    if (selectedDate.getDay() === 6 || selectedDate.getDay() === 0) {
        alert("Les weekends ne sont pas autorisés comme délai d'exécution. Veuillez choisir une autre date.");
        input.value = ''; // Réinitialiser la valeur du champ date
    }
}
</script>

