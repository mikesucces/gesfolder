
$(document).ready(function() {
  $(".toggle-input").on("change", function() {
    var id = $(this).data("id");
    var statut = $(this).is(":checked") ? "Validé" : "Rejeté";
    updateStatut(id, statut);
  });
  
  function updateStatut(id, statut) {
    var statusMessage = "";
  var statusClass = "";

  if (statut === "Validé") {
    statusMessage = "Demande validée";
    statusClass = "valide";
  } else if (statut === "Rejeté") {
    statusMessage = "Demande rejetée";
    statusClass = "rejete";
  } else {
    statusMessage = "Demande en attente";
    statusClass = "en-attente";
  }

  $(".status[data-id='" + id + "']").text(statusMessage).removeClass().addClass("status " + statusClass);
  }
});

