<style>
    .green {
        color: green;
    }
    .yellow {
        color: yellow;
    }
    .orange {
        color: orange;
    }
    .red {
        color: red;
    }
    .gray {
        color: gray;
    }
    .sort-icon {
        margin-left: 5px;
    }
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
    $countQuery = "SELECT COUNT(*) AS total
               FROM demande
               INNER JOIN utilisateur ON demande.id_users = utilisateur.matricule
               INNER JOIN direction ON utilisateur.direction_users = direction.code
               WHERE demande.etat = '1' AND statut = '$statut'";
    $countResult = $connexion->query($countQuery);
    if ($countResult && $countResult->num_rows > 0) {
        $countRow = $countResult->fetch_assoc();
        return $countRow['total'];
    } else {
        return 0;
    }
}

// Récupérer les compteurs par statut
$countPause = countDemandeByStatut('Attente');
$countApprouve = countDemandeByStatut('Valider');
$countRejete = countDemandeByStatut('Rejeter');
$countPublier = countDemandeByStatut('Publier');
$countTransmis = countDemandeByStatut('Transmis');

// Vérifier le statut sélectionné
$selectedStatut = isset($_GET['statut']) ? $_GET['statut'] : 'all'; // Par défaut, afficher toutes les demandes
$countQuery = "SELECT COUNT(*) AS total
               FROM demande
               INNER JOIN utilisateur ON demande.id_users = utilisateur.matricule
               INNER JOIN direction ON utilisateur.direction_users = direction.code
               WHERE demande.etat = '1'";
if ($selectedStatut !== 'all') {
    $countQuery .= " AND statut = '$selectedStatut'";
}
$countResult = $connexion->query($countQuery);

// Vérification du résultat de la requête COUNT()
if ($countResult && $countResult->num_rows > 0) {
    $countRow = $countResult->fetch_assoc();
    $totalItems = $countRow['total'];
} else {
    $totalItems = 0;
}

$itemsPerPage = 10; // Nombre d'éléments par page
$totalPages = ceil($totalItems / $itemsPerPage);

$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Paramètres de tri
$orderBy = isset($_GET['orderBy']) ? $_GET['orderBy'] : 'numero'; // Colonne par défaut pour le tri
$order = isset($_GET['order']) && $_GET['order'] === 'asc' ? 'ASC' : 'DESC'; // Ordre par défaut

// Requête SQL avec LIMIT et tri
$sql2 = "SELECT demande.*, direction.sigle AS direction_sigle, 
utilisateur.username AS agent_mail,  
utilisateur.nom AS agent_nom, 
utilisateur.prenoms AS agent_prenoms 
FROM demande 
JOIN utilisateur ON demande.id_users = utilisateur.matricule 
JOIN direction ON utilisateur.direction_users = direction.code ";
if ($selectedStatut !== 'all') {
    $sql2 .= " WHERE statut = '$selectedStatut'";
}
$sql2 .= " ORDER BY $orderBy $order LIMIT $offset, $itemsPerPage";
$resultat = $connexion->query($sql2);
$numeration = $offset + 1; // Numérotation du tableau

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
echo '<button class="' . ($selectedStatut === 'all' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=all\'" title="Tous">Tous</button>';
//echo '<button class="' . ($selectedStatut === 'Enregistrer' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=Enregistrer\'" title="Demande Enregistrer"><i class="fa fa-save ' . ($selectedStatut === 'Enregistrer' ? 'yellow' : '') . '"></i> <span class="counter">(' . $countEnAttente . ')</span></button>';
echo '<button class="' . ($selectedStatut === 'Transmis' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=Transmis\'" title="Demande transmise"><i class="fa fa-directions ' . ($selectedStatut === 'Transmis' ? 'orange' : '') . '"> Transmises  <span class="counter">(' . $countTransmis . ')</span></i></button>';
echo '<button class="' . ($selectedStatut === 'Attente' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=Attente\'" title="Demande en traitement"><i class="fa fa-list ' . ($selectedStatut === 'Attente' ? 'gray' : '') . '"> En traitement <span class="counter">(' . $countPause . ')</span> </i> </button>';
echo '<button class="' . ($selectedStatut === 'Valider' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=Valider\'" title="Demande valider"><i class="fas fa-check-circle ' . ($selectedStatut === 'Valider' ? 'green' : '') . '"> A publier <span class="counter">(' . $countApprouve . ')</span> </i> </button>';
echo '<button class="' . ($selectedStatut === 'Publier' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=Publier\'" title="Demande publier"><i class="fas fa fa-bullhorn ' . ($selectedStatut === 'Publier' ? 'green' : '') . '"> Publiées <span class="counter">(' . $countPublier . ')</span></i></button>';
echo '<button class="' . ($selectedStatut === 'Rejeter' ? 'selected' : '') . ' btn btn-link" onclick="window.location.href=\'?statut=Rejeter\'" title="Demande rejeter"><i class="fas fa-times-circle ' . ($selectedStatut === 'Rejeter' ? 'red' : '') . '"> Rejetées <span class="counter">(' . $countRejete . ')</span></i></button>';
echo '<button id="imprimerTableau" class="btn btn-primary">Imprimer</button>';

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
    echo "<table id=votreTableau>";
    echo "<tr>";
    echo "<th>N°</th>";
    echo "<th>Nature</th>";
    echo "<th><a href='?statut=$selectedStatut&orderBy=libelle&order=" . ($orderBy === 'libelle' ? ($order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Objet</a><span class='sort-icon " . getSortIconClass('libelle', $orderBy, $order) . "'></span></th>";
  
    echo "<th>Direction</th>";
    echo "<th><a href='?statut=$selectedStatut&orderBy=date&order=" . ($orderBy === 'date' ? ($order === 'asc' ? 'desc' : 'asc') : 'asc') . "'>Date de transmission</a><span class='sort-icon " . getSortIconClass('date', $orderBy, $order) . "'></span></th>";
    echo "<th>Délai d'exécution</th>";
    if($selectedStatut==='Publier'){echo "<th>Date de publication</th>";}
    if($selectedStatut==='Rejeter'){echo "<th>Date de rejet</th>";}
    echo "<th>Statut</th>";
  //  echo "<th>Expediteur de la demande</th>";
   // echo "<th>Commentaire</th>";
  //  echo "<th>Statut</th>";
   
  if($statut_utilisateur !='users'){ echo "<th>Détails</th>";}


  if($selectedStatut==='Valider') {if(($statut_utilisateur!='admin') ){echo "<th>Action</th>";}}
 
  echo "</tr>";
    while ($ligne = $resultat->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $numeration . "</td>";
        echo "<td>" . $ligne["nature"] . "</td>";
        echo "<td>" . $ligne["libelle"] . "</td>";
      
        echo "<td>" . $ligne["direction_sigle"] . "</td>";
        echo "<td>" . date("d-m-Y", strtotime($ligne["date"])) . "</td>";
        echo "<td>" . date("d-m-Y", strtotime($ligne["delai"])) . "</td>";
        if($selectedStatut==='Publier'){ echo "<td>" . date("d-m-Y", strtotime($ligne["date_publication"])) . "</td>";}
        if($selectedStatut==='Rejeter'){ echo "<td>" . date("d-m-Y", strtotime($ligne["date_rejet"])) . "</td>";}
       
        if ($ligne["statut"]=='Valider'|| $ligne["statut"]=='Publier'){echo "<td style='color: green'><b>" . $ligne["statut"] . "</b></td>";}
        elseif ($ligne["statut"]=='Rejeter'){echo "<td style='color: red'><b>" . $ligne["statut"] . "</b></td>";}
        else{echo "<td><b>" . $ligne["statut"] . "</b></td>";}

  if ($statut_utilisateur == 'admin') {echo "<td><a href='modifier.php?id=" . $ligne["numero"] . "'><i class='far fa-eye' style='color: green;'></i></a></td>"; }
  
  if ($statut_utilisateur == 'administrateur'){ 
    if ($selectedStatut==='Transmis'){ echo "<td><a href='modifier.php?id=" . $ligne["numero"] . "&statut=Attente'><i class='far fa-eye' style='color: green;'></i></a></td>";}
  else{echo "<td><a href='modifier.php?id=" . $ligne["numero"] . "'><i class='far fa-eye' style='color: green;'></i></a></td>";}   
  }


      if(($statut_utilisateur =='administrateur') ){
        $id2=$ligne["statut"];

     if ($id2==='Transmis'){
    //echo "<td><a href='modifier.php?id=" . $ligne["numero"] . "&statut=Attente&date=" . $date_actuelle . "'><i class='far fa-eye'></i></a></td>";
    //  echo "<td> <i class='fa fa-mouse-pointer publish-icon' style='color: blue; cursor: pointer;' data-id=".$ligne['numero']."></i></td>";
    //echo "<td><a href='modifier.php?id=" . $ligne["numero"] . "&statut=Attente'><i class='fa fa-mouse-pointer'></a></td>";
      
     } else if ($id2==='Valider'){echo "<td> <i class='fa fa-mouse-pointer publish-icon' style='color: green; cursor: pointer;' data-id=".$ligne['numero']."></i> </td>";
      
     }
  
  }
     // echo '<td><a href="#" class="update-link" data-id="' . $ligne["numero"] . '" data-statut="' . $ligne["statut"] . '"><i class="far fa-eye"></i></a></td>'; 
        echo "</tr>";
        $numeration++;
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



<script>
$(document).ready(function() {
  $('.update-link').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    var statut = $(this).data('statut');
    if (statut === 'Transmis') {
      updateStatut(id);
    } else {
      console.log('Le statut doit être "Transmis" pour effectuer la mise à jour.');
    }
  });

  function updateStatut(id) {
    $.ajax({
      type: 'POST',
      url: 'update_statut.php',
      data: { id: id, statut: 'Attente' },
      success: function(response) {
        // Si la requête a réussi, actualiser la page pour afficher les modifications
        location.reload();
      },
      error: function() {
        console.log('Erreur lors de la mise à jour du statut.');
      }
    });
  }
});
</script>


<!-- IMPRESSION DES DEMANDES -->
<script>
   document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('imprimerTableau').addEventListener('click', function () {
        // Créez une nouvelle fenêtre pour l'impression
        var fenetreImpression = window.open('', '_blank');

        // Ciblez votre tableau par son ID
        var tableauAImprimer = document.getElementById('votreTableau');

        // Obtenez le nombre de colonnes du tableau
        var nombreColonnes = tableauAImprimer.rows[0].cells.length;

        // Masquez la dernière colonne
        var lastColumnIndex = nombreColonnes - 1;
        for (var i = 0; i < tableauAImprimer.rows.length; i++) {
            tableauAImprimer.rows[i].cells[lastColumnIndex].style.display = 'none';
        }

        // Appliquez le style pour espacer les colonnes et encadrer le tableau
        tableauAImprimer.style.borderCollapse = 'collapse';
        tableauAImprimer.style.width = '100%';

        // Ajoutez la classe spécifique pour centrer les titres des colonnes
        var titresColonnes = tableauAImprimer.querySelectorAll('.titre-colonne');
        titresColonnes.forEach(function (titreColonne) {
            titreColonne.style.textAlign = 'center';
        });

        // Parcourez les lignes et colonnes du tableau pour appliquer le style
        for (var i = 0; i < tableauAImprimer.rows.length; i++) {
            for (var j = 0; j < tableauAImprimer.rows[i].cells.length; j++) {
                tableauAImprimer.rows[i].cells[j].style.border = '1px solid black';
                tableauAImprimer.rows[i].cells[j].style.padding = '8px';
                tableauAImprimer.rows[i].cells[j].style.textAlign = 'center';
            }
        }

        // Ajoutez le contenu du tableau à la nouvelle fenêtre
        fenetreImpression.document.write('<html><head><title>GESTION DE FICHIERS</title>');

        // Ajoutez le style pour le mode paysage
        fenetreImpression.document.write('<style>@page { size: landscape; }</style>');

        // Ajoutez le filigrane en diagonale sous forme de texte
        fenetreImpression.document.write('<style>body::after { content: "DGBF"; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-45deg); font-size: 250px; opacity: 0.1; text-align: center; }</style>');

        fenetreImpression.document.write('</head><body>');
        fenetreImpression.document.write('<h1><center>TABLEAU DE DEMANDE</center></h1>');
        fenetreImpression.document.write(tableauAImprimer.outerHTML);
        fenetreImpression.document.write('</body></html>');

        // Fermez la fenêtre d'impression après l'impression
        fenetreImpression.document.close();
        fenetreImpression.print();
        fenetreImpression.close();
    });
});

</script>




<!-- JavaScript pour la Publication et la mise à jour du statut -->
<script>
$(document).ready(function() {
  $('.publish-icon').click(function(e) {
    e.preventDefault();
    var requestId = $(this).data('id');

    // Utilisez une boîte de dialogue de confirmation (Swal) pour confirmer la publication
    Swal.fire({
      title: 'Confirmer la publication',
      text: 'Êtes-vous sûr de vouloir publié cette demande ?',
      icon: 'info',
      showCancelButton: true,
      confirmButtonText: 'Oui, publier',
      cancelButtonText: 'Annuler'
    }).then((result) => {
      if (result.isConfirmed) {
        // L'utilisateur a confirmé, appelez la fonction pour publier la demande
        publishRequest(requestId);
      }
    });
  });

  function publishRequest(requestId) {
    $.ajax({
      type: 'POST',
      url: 'publish_request.php', // Assurez-vous de créer ce fichier pour la mise à jour du statut
      data: { requestId: requestId },
      success: function(response) {
        // Si la requête a réussi, actualisez la page pour afficher les modifications
        location.reload();
      },
      error: function() {
        console.log('Erreur lors de la mise à jour du statut.');
      }
    });
  }
});
</script>


<script src="js/reload.js"></script>
