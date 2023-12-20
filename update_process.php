<?php
// Vérification de l'envoi du formulaire
if (isset($_POST['modifier'])) {
    // Récupération des données du formulaire
    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Connexion à la base de données
    $bdd = new PDO('mysql:host=localhost;dbname=nom_de_la_base_de_donnees;charset=utf8', 'nom_utilisateur', 'mot_de_passe');

    // Vérification de l'existence de l'utilisateur
    $query = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $query->execute([$id]);
    $user = $query->fetch();

    if ($user) {
        // Mise à jour des données de l'utilisateur
        $query = $bdd->prepare("UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, password = ? WHERE id = ?");
        $query->execute([ $email, $password, $id]);

        // Redirection vers la page de profil de l'utilisateur
        header('Location: profil.php?id='.$id);
        exit();
    } else {
        // Redirection vers la page d'erreur
        header('Location: erreur.php');
        exit();
    }
} else {
    // Redirection vers la page d'accueil si le formulaire n'a pas été envoyé
    header('Location: index.php');
    exit();
}
