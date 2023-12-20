// Tableau pour stocker les noms des fichiers sélectionnés
var selectedFiles = [];

// Fonction pour ouvrir le modèle
function openModal() {
    document.getElementById("myModal").style.display = "block";
}

// Fonction pour fermer le modèle
function closeModal() {
    document.getElementById("myModal").style.display = "none";
}

// Fonction pour afficher les noms de fichiers sélectionnés
function displaySelectedFiles() {
    var input = document.querySelector('input[type="file"]');
    var fileList = document.getElementById("fileList");

    // Effacer la liste précédente
    fileList.innerHTML = "";

    // Réinitialiser le tableau des fichiers sélectionnés
    selectedFiles = [];

    // Parcourir les fichiers sélectionnés
    for (var i = 0; i < input.files.length; i++) {
        var fileName = input.files[i].name;

        // Ajouter le nom du fichier au tableau des fichiers sélectionnés
        selectedFiles.push(fileName);

        // Créer un élément de liste pour chaque fichier
        var listItem = document.createElement("li");
        listItem.textContent = fileName;

        // Ajouter l'élément de liste à la liste des fichiers
        fileList.appendChild(listItem);
    }
}

// Fonction pour supprimer les fichiers sélectionnés
function deleteSelectedFiles() {
    var fileList = document.getElementById("fileList");

    // Vérifier s'il y a des fichiers sélectionnés à supprimer
    if (selectedFiles.length > 0) {
        // Parcourir les noms des fichiers sélectionnés
        for (var i = 0; i < selectedFiles.length; i++) {
            var fileName = selectedFiles[i];
            var listItem = fileList.querySelector("li");

            // Supprimer l'élément de liste correspondant au fichier
            fileList.removeChild(listItem);

            // Supprimer le fichier du tableau des fichiers sélectionnés
            selectedFiles.splice(i, 1);

            // En option: Ajouter ici le code pour supprimer physiquement le fichier du serveur
            // Utilisez une méthode appropriée pour supprimer le fichier, comme l'envoi d'une requête AJAX au serveur

            // Réduire le compteur car on a supprimé un élément
            i--;
        }

        // Afficher un message de confirmation ou effectuer d'autres actions nécessaires
        console.log("Les fichiers sélectionnés ont été supprimés avec succès !");
    }
}