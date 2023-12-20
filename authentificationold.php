<?php
// On initialise les variables de saisie avec des valeurs vides
$login = '';
$password = '';

// On vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les informations saisies par l'utilisateur
    $login = $_POST['username'];
    $password = $_POST['password'];

    // On se connecte à la base de données

    echo "Login: $login<br>";
    echo "Password: $password<br>";
    
    


// Informations de connexion à la base de données
    $serveur = "localhost";
    $utilisateur = "root";
    $motDePasse = "F0lder";
    $nomBaseDeDonnees = "base";

    // Création de la connexion
   // $connexion = new mysqli($serveur, $utilisateur, $motDePasse, $nomBaseDeDonnees);
	
	$connexion = new PDO('mysql:host= $serveur;dbname= $nomBaseDeDonnees',  $utilisateur , $motDePasse);

    // Vérification de la connexion



	if (!$connexion->connect_error) {
    // Échappez les variables pour éviter les injections SQL (utilisez mysqli_real_escape_string ou des requêtes préparées)
    $login = $connexion->real_escape_string($login);

    // Requête SQL pour sélectionner l'utilisateur en fonction du nom d'utilisateur (login)
    $query = "SELECT * FROM utilisateur WHERE username = '$login'";

    // Exécutez la requête SQL
    $resultat = $connexion->query($query);

    // Vérifiez si la requête a réussi
    if ($resultat) {
        // Récupérez les données de l'utilisateur
        $user = $resultat->fetch_assoc();

        // Vérifiez si un utilisateur correspondant a été trouvé
        if ($user) {
            // Affichez les informations de l'utilisateur
              session_start();
        $_SESSION['user_id'] = $user['matricule'];
        $_SESSION['user_role'] = $user['habilitation'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_prename'] = $user['prenoms'];
        $_SESSION['user_direction'] = $user['direction_users'];
        $_SESSION['user_role'] = $user['habilitation'];

        // Après la validation des informations d'identification
// et la création de la session, définir la variable de session
$_SESSION['loggedin'] = true;


        // Redirection vers la page demande.php
        header("Location: demande.php");
        $connexion_reussie = true;

   $_POST['username']="";
    $_POST['password']="";
            // Ajoutez d'autres colonnes au besoin
        } else {
            echo "Aucun utilisateur correspondant trouvé.";
        }

        // Fermez le résultat
        $resultat->close();
    } else {
        echo "Erreur lors de l'exécution de la requête : " . $connexion->error;
    }
} else {
    echo "Erreur de connexion à la base de données.";
}

}
?>
