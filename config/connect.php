
<?php
// On récupère les informations envoyées par le formulaire de connexion


    // On se connecte à la base de données
    $pdo = new PDO('mysql:host=localhost;dbname=base', 'root', '');

    // On vérifie les informations de connexion
    $query = "SELECT * FROM Utilisateur WHERE username=:login AND password=:password";
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':login', $login);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Si les informations de connexion sont correctes, on crée une session et on redirige l'utilisateur vers la page d'accueil
        session_start();
        $_SESSION['user_id'] = $user['matricule'];
        $_SESSION['user_role'] = $user['habilitation'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_prename'] = $user['prenoms'];
        $_SESSION['user_direction'] = $user['direction_users'];
        $_SESSION['user_username'] = $user['username'];
        header('Location: demande.php');
        exit;
    } else {
        // Si les informations de connexion sont incorrectes, on affiche un message d'erreur
        $error_message = "Erreur de Login ou mot de passe incorrect.";
    }

// On affiche le formulaire de connexion
?>