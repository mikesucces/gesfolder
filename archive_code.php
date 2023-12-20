
<!--script>

    // Cette fonction sera appelée lorsque le formulaire est soumis
function soumettreFormulaire() {

     // Récupérer la date sélectionnée
     var selectedDate = new Date($('#delai').val());

    
    // Vérifier si la date sélectionnée est un samedi (jour de la semaine 6) ou un dimanche (jour de la semaine 0)
    if (selectedDate.getDay() === 6 || selectedDate.getDay() === 0) {
        alert("Les weekends ne sont pas autorisés comme délai d'exécution. Veuillez choisir une autre date.");
        input.value = ''; // Réinitialiser la valeur du champ date
    }
    // Récupérer les données du formulaire
    var nature = $('#nature').val();
    var libelle = $('#libelle').val();
    var delai = $('#delai').val();
    var instruction = $('#instruction').val();
    var numero = $('#numero').val();
    var commentaire = $('#commentaire').val();
    // Créer un objet contenant les données à envoyer
    var donnees = {
        nature: nature,
        libelle: libelle,
        delai: delai,
        instruction: instruction,
        numero:numero,
        commentaire:commentaire
    };

    // Effectuer une requête Ajax POST pour envoyer les données au serveur
    $.ajax({
        type: 'POST',
        url: 'demande_process.php', // L'URL du script PHP qui traitera les données
        data: donnees,
        success: function (response) {
            // La requête a réussi, vous pouvez afficher la réponse ici
            // Vous pouvez également afficher une boîte de dialogue SweetAlert pour afficher un message
            Swal.fire({
                icon: 'success',
                title: 'Succès',
                text: 'La demande a été soumise avec succès.'
            });

            // Vous pouvez également réinitialiser le formulaire si nécessaire
            $('#nature').val('');
            $('#libelle').val('');
            $('#delai').val('');
            $('#instruction').val('');

            setTimeout(function () {
        location.reload();
    }, 2000); // 1000 millisecondes équivalent à 1 seconde
        },
        error: function (error) {
            // La requête a échoué, vous pouvez gérer les erreurs ici
            Swal.fire({
                icon: 'error',
                title: 'Erreur',
                text: 'Une erreur s\'est produite lors de la soumission de la demande.'
            });
        }
    });

    // Empêcher le formulaire de se soumettre normalement
    return false;

}

// Associer la fonction soumettreFormulaire à l'événement de soumission du formulaire
//$(document).ready(function () {
 //   $('#demande.php').submit(soumettreFormulaire);
//});

</script>
