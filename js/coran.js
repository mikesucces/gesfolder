$(document).ready(function() {
    var table = $('#tableau').DataTable();

    $('#ajouterLigne').on('click', function() {
        $('#modalAjout').css('display', 'block');
    });

    $('#ajouter').on('click', function() {
                var nom = $('#libelle').val();
                var age = $('#instruction').val();
                
                table.row.add([nom, age, ville]).draw();

                $('#libelle').val('');
                $('#instruction').val('');
           

                $('#modalAjout').css('display', 'none');
    });

    $('#fermer').on('click', function() {
        $('#modalAjout').css('display', 'none');
    });
});



		$(document).ready(function() {
    $('#tableau').DataTable({
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
        }
    });



});


$(document).ready(function() {
    $('#example').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
        }
    });
});


// Récupérer l'élément de saisie de recherche
var input = document.getElementById("searchInput");

// Ajouter un gestionnaire d'événement d'entrée de recherche
input.addEventListener("input", function () {
    // Convertir la saisie de recherche en minuscules
    var filter = input.value.toLowerCase();

    // Récupérer le tableau et les lignes du tableau
    var table = document.getElementById("myTable");
    var rows = table.getElementsByTagName("tr");

    // Parcourir toutes les lignes du tableau, en commençant par l'index 1 pour ignorer la ligne d'en-tête
    for (var i = 1; i < rows.length; i++) {
        var row = rows[i];
        var cells = row.getElementsByTagName("td");
        var found = false;

        // Parcourir toutes les cellules de chaque ligne
        for (var j = 0; j < cells.length; j++) {
            var cell = cells[j];

            // Vérifier si la valeur de la cellule correspond à la saisie de recherche
            if (cell.innerHTML.toLowerCase().indexOf(filter) > -1) {
                found = true;
                break;
            }
        }

        // Afficher ou masquer la ligne en fonction de si la recherche correspond à une valeur dans la ligne
        if (found) {
            row.style.display = "";
        } else {
            row.style.display = "none";
        }
    }
});

function confirmDelete() {
return confirm("Êtes-vous sûr de vouloir supprimer cette ligne ?");
}