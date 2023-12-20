
var currentTab = 0; // Actuellement visible estape
showTab(currentTab); // Affiche l'étape actuelle

function showTab(n) {
    // Affiche l'étape spécifiée du formulaire
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";

    // Met à jour le bouton "Previous" / "Next" en fonction de l'étape actuelle
    if (n == 0) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
    }

    // Indique l'étape actuelle
    fixStepIndicator(n);

    // Affiche les informations récapitulatives à la dernière étape
    if (n == (x.length - 1)) {
        displaySummary();
    }
}


function displaySummary() {
    var email = document.getElementById("email").value;
    var token = document.getElementById("token").value;
    var password = document.getElementById("new_password").value;

    document.getElementById("summaryEmail").innerText = email;
    document.getElementById("summaryToken").innerText = token;
    document.getElementById("summaryPassword").innerText = password;
}

function nextPrev(n) {
    // Navigue vers l'étape suivante ou précédente
    var x = document.getElementsByClassName("tab");
    // Sort de la fonction si un champ est vide et que l'utilisateur tente de passer à l'étape suivante
    if (n == 1 && !validateForm()) return false;
    // Cache l'étape actuelle
    x[currentTab].style.display = "none";
    // Passe à l'étape suivante ou précédente
    currentTab = currentTab + n;
    // Affiche l'étape actuelle
    showTab(currentTab);
}


function validateForm() {
    // Valide les champs du formulaire à chaque étape
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    y = x[currentTab].getElementsByTagName("input");
    for (i = 0; i < y.length; i++) {
        if (y[i].value == "") {
            // Marque les champs vides avec une couleur rouge
            y[i].className += " invalid";
            // Indique que le formulaire n'est pas valide
            valid = false;

            // Affiche un message d'erreur
            document.getElementById("error-message").innerHTML = "Veuillez remplir tous le(s) champ(s).";

            // Optionnel : Faites en sorte que le message d'erreur disparaisse après un certain temps
            setTimeout(function() {
                document.getElementById("error-message").innerHTML = "";
            }, 3000);  // Disparaît après 3 secondes (ajustez selon vos besoins)
        }
    }
    return valid; // Renvoie l'état de validation du formulaire
}


function fixStepIndicator(n) {
    // Supprime la classe "active" de tous les indicateurs d'étape
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    // Ajoute la classe "active" à l'indicateur d'étape actuel
    x[n].className += " active";
}

