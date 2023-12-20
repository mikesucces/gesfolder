<style>
    .green { color: green; }
    .yellow {color: brown;}
    .orange {color: orange; }
    .red { color: red;}
    .gray {color: gray;}
    .purple { color: purple; }
    .sort-icon { margin-left: 5px;}

    .ligne-bleue { color: blue;font-weight: bold;}
  
</style>


<?php

$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['user_name'];
$prenons_utilisateur = $_SESSION['user_prename'];
$direction_utilisateur = $_SESSION['user_direction'];
$statut_utilisateur = $_SESSION['user_role'];

include('config/dbconnect.php');

$sqlSelect = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
$result = $connexion->query($sqlSelect);


$numeration = 1; // Numérotation du tableau

if ($result->num_rows > 0) {
    // Récupérer la valeur du libellé
    $row = $result->fetch_assoc();
    $libelleDirection = $row['sigle'];
} else {
}

// Fonction pour compter le nombre de demandes en fonction du statut
function countDemandeByStatut($statut)
{
    global $connexion, $id_utilisateur;
    $countQuery = "SELECT COUNT(*) AS total FROM demande WHERE id_users = $id_utilisateur AND statut = '$statut' AND etat = '1'";
    $countResult = $connexion->query($countQuery);

    //pagination
    if ($countResult && $countResult->num_rows > 0) {
        $countRow = $countResult->fetch_assoc();
        return $countRow['total'];
    } else {
        return 0;
    }
}
function getCountSuiviDemande()
{
    global $connexion, $id_utilisateur;

    $sql = "SELECT COUNT(*) AS count FROM demande WHERE (statut = 'Transmis' OR statut = 'Attente') AND id_users = $id_utilisateur AND etat = '1'";
    $result = $connexion->query($sql);

    //pagination
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    } else {
        return 0;
    }
}


// Récupérer les compteurs par statut
$countEnAttente = countDemandeByStatut('Enregistrer');
$countApprouve = countDemandeByStatut('Valider');
$countRejete = countDemandeByStatut('Rejeter');
$countTransmis = countDemandeByStatut('Transmis');
$countPause = countDemandeByStatut('Attente');
$countPublier = countDemandeByStatut('Publier');
$countSuiviDemande = getCountSuiviDemande();



// Vérifier le statut sélectionné
$selectedStatut = isset($_GET['statut']) ? $_GET['statut'] : 'all'; // Par défaut, afficher toutes les demandes

$countQuery = "SELECT COUNT(*) AS total FROM demande WHERE id_users = $id_utilisateur";
if ($selectedStatut !== 'all') {
    $countQuery .= " AND statut = '$selectedStatut'";
}


$countResult = $connexion->query($countQuery);

// Vérification du résultat de la requête COUNT()
if ($countResult && $countResult->num_rows > 0) {
    $countRow = $countResult->fetch_assoc();

    if ($selectedStatut === 'SuiviDemande') {
        $totalItems = $countSuiviDemande;
    } else {
        $totalItems = $countRow['total'];
    }
} else {
    $totalItems = 0;
}



//NOMBRE D'ENREGISTREMENT AFFICHER PAR PAGE

$itemsPerPage = 5; // Nombre d'éléments par page
$totalPages = ceil($totalItems / $itemsPerPage);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// FIN




// TRI DE RECHERCHE PAR COLONNE 

// Paramètres de tri
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'numero'; // Colonne par défaut pour le tri
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'asc' : 'desc'; // Ordre par défaut

// FIN 



// Requête SQL avec LIMIT et tri
$sql = "SELECT * FROM demande WHERE id_users = $id_utilisateur";
if ($selectedStatut !== 'all') {
    if ($selectedStatut === 'SuiviDemande') {
        $sql .= " AND (statut = 'attente' OR statut = 'transmis')";
    } else {
        $sql .= " AND statut = '$selectedStatut'";
    }
}
$sql .= " ORDER BY $orderBy $order LIMIT $offset, $itemsPerPage";
$resultat = $connexion->query($sql);
$numeration = $offset + 1; // Numérotation du tableau
// Numérotation du tableau

// Fonction pour générer la classe CSS pour l'icône de tri


function getSortIconClass($column, $orderBy, $order)
{
    if ($orderBy === $column) {
        return $order === 'asc' ? 'fa fa-sort-up' : 'fa fa-sort-down';
    }
    return 'fa fa-sort';
}
// Affichage des boutons de filtrage par statut
echo '<div class="row">';
echo '<div class="col-md-9">';
echo '<div class="statut-buttons">';
echo '<a class="' . ($selectedStatut === 'all' ? 'selected' : 'btn btn-link') . '" href="?statut=all" title="Tous" style="text-decoration: none;">Tous</a>';
//echo '<a class="' . ($selectedStatut === 'Enregistrer' ? 'selected' : 'btn btn-link') . '" href="?statut=Enregistrer" title="Demande Enregistrée" style="text-decoration: none;"><i class="fa fa-save ' . ($selectedStatut === 'Enregistrer' ? 'yellow' : '') . '"> Enregistrer</i><span class="counter">(' . $countEnAttente . ')</span></a>';
//echo '<a class="' . ($selectedStatut === 'SuiviDemande' ? 'selected' : 'btn btn-link') . '" href="?statut=SuiviDemande" title="Suivi Demande" style="text-decoration: none;"><i class="fas fa-th-list ' . ($selectedStatut === 'SuiviDemande' ? 'purple' : '') . '"> Transmis <span class="counter">(' . $countSuiviDemande . ')</span></i></a>';
echo '<a class="' . ($selectedStatut === 'Transmis' ? 'selected' : 'btn btn-link') . '" href="?statut=Transmis" title="Demande transmise" style="text-decoration: none;"><i class="fa fa-directions ' . ($selectedStatut === 'Transmis' ? 'orange' : '') . '"> Transmise <span class="counter">(' . $countTransmis . ')</span></i> </a>';
echo '<a class="' . ($selectedStatut === 'Attente' ? 'selected' : 'btn btn-link') . '" href="?statut=Attente" title="Demande en traitement" style="text-decoration: none;"><i class="fa fa-list ' . ($selectedStatut === 'Attente' ? 'gray' : '') . '"> En traitement <span class="counter">(' . $countPause . ')</span></i> </a>';
//echo '<a class="' . ($selectedStatut === 'Valider' ? 'selected' : 'btn btn-link') . '" href="?statut=Valider" title="Demande validée" style="text-decoration: none;"><i class="fas fa-check-circle ' . ($selectedStatut === 'Valider' ? 'green' : '') . '"> Valider</i> <span class="counter">(' . $countApprouve . ')</span></a>';

//echo '<button class="btn' . ($selectedStatut === 'Valider' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=Valider\'" title="Demande valider"><i class="fas fa-check-circle ' . ($selectedStatut === 'Valider' ? 'green' : '') . '"> A publier <span class="counter">(' . $countApprouve . ')</span></i></button>';

echo '<a class="' . ($selectedStatut === 'Publier' ? 'selected' : 'btn btn-link') . '" href="?statut=Publier" title="Demande publier" style="text-decoration: none;"><i class="fas fa fa-bullhorn ' . ($selectedStatut === 'Publier' ? 'green' : '') . '"> Publiée <span class="counter">(' . $countPublier . ')</span></i></a>';
echo '<a class="' . ($selectedStatut === 'Rejeter' ? 'selected' : 'btn btn-link') . '" href="?statut=Rejeter" title="Demande rejetée" style="text-decoration: none;"><i class="fas fa-times-circle ' . ($selectedStatut === 'Rejeter' ? 'red' : '') . '"> Rejetée <span class="counter">(' . $countRejete . ')</span></i></a>';






echo '</div>';
echo '</div>';





echo '<div class="col-md-3">';
echo '<div class="text-right">';
echo '<input style="width: 300px; border-radius: 5px;" type="text" id="searchInput" class="form-control" placeholder="Rechercher..." onkeyup="searchTable()">';
echo '</div>';
echo '</div>';

echo '</div>';



// Affichage du tableau

if ($resultat && $resultat->num_rows > 0) {
    echo '<table id=votreTableau1>';
    echo "<tr>";
    echo "<th>N°</th>";
    echo "<th>Nature</th>";
    echo "<th><a href='?statut=$selectedStatut&orderBy=libelle&order=" . ($orderBy === 'libelle' ? ($order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Objet</a><span class='sort-icon " . getSortIconClass('libelle', $orderBy, $order) . "'></span></th>";
   // echo "<th>Détails demande</th>";
    echo "<th><a href='?statut=$selectedStatut&orderBy=date&order=" . ($orderBy === 'date' ? ($order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Date de transmission</a><span class='sort-icon " . getSortIconClass('date', $orderBy, $order) . "'></span></th>";
    echo "<th>Délai d'exécution</th>";

    if($selectedStatut==='Publier'){echo "<th>Date de publication</th>";}
    if($selectedStatut==='Rejeter'){echo "<th>Date de rejet</th>";}
    echo "<th>Fiche</th>";
    echo "<th>Statut</th>";
    echo "<th>Détails</th>";
    echo "</tr>";
    

    

    while ($row = $resultat->fetch_assoc()) {
        if ($selectedStatut === 'SuiviDemande' && !in_array($row['statut'], ['Attente', 'Transmis'])) {
            continue;
        }
            // condition pour afficher la ligne a verifier en bleu 
        if (($row["statut"] === 'Publier' || $row["statut"] === 'Rejeter') && ($row["etat"] != '4')) {
            echo "<tr class='ligne-bleue'>";
        } else {
            echo "<tr>";
        }
        

        echo "<td>" . $numeration . "</td>";
        echo "<td>" .$row["nature"] . "</td>";
        echo "<td>" . $row["libelle"] . "</td>";
      //  echo "<td>" . $row["instruction"] . "</td>";
        echo "<td>" . date("d-m-Y", strtotime($row["date"])) . "</td>";
        echo "<td>" . date("d-m-Y", strtotime($row["delai"])) . "</td>";
        if($selectedStatut==='Publier'){ echo "<td>" . date("d-m-Y", strtotime($row["date_publication"])) . "</td>";}
        if($selectedStatut==='Rejeter'){ echo "<td>" . date("d-m-Y", strtotime($row["date_rejet"])) . "</td>";}

         $reference= $row["reference"];
       // $cheminFichierPDF = 'uploads/' . $libelleDirection . '/' . $reference . '.pdf';
        $cheminFichierPDF = 'uploads/' . $libelleDirection . '/pdf/' . $reference . '.pdf';
        if (file_exists($cheminFichierPDF)) {
            // Le fichier PDF existe, nous pouvons afficher l'icône et le lien
            $icone = '<i class="fas fa-file-pdf" style="color: red;"></i>'; // Icône PDF avec couleur rouge
            $lienPDF = $cheminFichierPDF; // Lien vers le fichier PDF
        
            echo '<td><a href="' . $lienPDF . '" target="_blank">' . $icone . '</a></td>';
        } else {
            // Le fichier PDF n'existe pas
            echo '<td></td>';
        }



        //if ($row["statut"]=='Valider'){echo "<td style='color: green'><b>" . $row["statut"] . "</b></td>";}
        if ($row["statut"]=='Valider'){echo "<td style='color: green'><b>Validée</b></td>";}
       // elseif ($row["statut"]=='Rejeter'){echo "<td style='color: red'><b>" . $row["statut"] . "</b></td>";}
        elseif ($row["statut"]=='Rejeter'){echo "<td style='color: red'><b>Rejetée</b></td>";}
        elseif($row["statut"]=='Attente'){echo "<td><b>En traitement</b></td>";}
        elseif($row["statut"]=='Publier'){echo "<td style='color: green'><b>Publiée</b></td>";}
        else{echo "<td><b>" . $row["statut"] . "</b></td>";}
       // fin ///




       echo "<td><a href='voir.php?id=" . $row["numero"] . "&statut=" . $row["statut"] . "'><i class='far fa-eye' style='color: green;'></i></a></td>";
        
             echo "</tr>";

        $numeration++; // Incrémentation de la numérotation
    }
    echo "</table>";
} else {
    echo "Aucun enregistrement trouvé.";
}

// Fermeture de la connexion
$connexion->close();

?>
   <!-- RECHERCHE DANS LE TABLEAU   -->
   <script>
function searchTable() {
  // Récupérer la valeur saisie dans le champ de recherche
  var input = document.getElementById("searchInput").value.toUpperCase();

  // Récupérer les lignes du tableau (à l'exception de la première ligne d'en-tête)
  var rows = document.querySelectorAll("table tr:not(:first-child)");

  // Réinitialiser la numérotation
  var numeration = 1;

  // Parcourir toutes les lignes du tableau et masquer celles qui ne correspondent pas à la recherche
  rows.forEach(function(row) {
    var cells = row.getElementsByTagName("td");
    var display = false;
    for (var i = 0; i < cells.length; i++) {
      var cell = cells[i];
      if (cell) {
        var text = cell.textContent || cell.innerText;
        if (text.toUpperCase().indexOf(input) > -1) {
          display = true;
          break;
        }
      }
    }
    row.style.display = display ? "" : "none";

    // Mettre à jour la numérotation visible
    if (display) {
      row.cells[0].textContent = numeration++;
    }
  });
}

// Ajouter un écouteur d'événement pour déclencher la recherche lors de la saisie
document.getElementById("searchInput").addEventListener("input", searchTable);
</script>


<script src="js/reload.js"></script>
