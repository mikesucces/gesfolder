<?php
// Vérification si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupération des données du formulaire
    $email = $_POST["email"];
    $newPassword = $_POST["password"];
    $confirmPassword = $_POST["confirm_password"];

    // Validation des données
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        echo "Veuillez remplir tous les champs du formulaire.";
    } elseif ($newPassword !== $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
    } else {
        // Connexion à la base de données et vérification de l'existence de l'e-mail dans la table des utilisateurs
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "base";

        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
            die("Échec de la connexion à la base de données: " . $conn->connect_error);
        }

        $email = $conn->real_escape_string($email); // Échapper les caractères spéciaux de l'e-mail

        $sql = "SELECT * FROM utilisateur WHERE username = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Mise à jour du mot de passe dans la base de données
            $sqlUpdate = "UPDATE utilisateur SET password = '$newPassword' WHERE username = '$email'";
            if ($conn->query($sqlUpdate) === TRUE) {
               // Style CSS personnalisé pour le message
  $style = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: green; padding: 40px; font-size: 36px; text-align: center;';
  
  // Afficher le message au milieu de la page avec animation
  echo '<div style="' . $style . '" class="animate__animated animate__heartBeat">Le mot de passe à été changé </div>';
  header("refresh:1; url=index.php");
            } else {
                $style1 = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: red; padding: 40px; font-size: 36px; text-align: center;';
  
                // Afficher le message au milieu de la page avec animation
                echo '<div style="' . $style1 . '" class="animate__animated animate__heartBeat">Le mot de passe à été changé </div>';
                header("refresh:1; url=resetpwd.php");
            }
        } else {
            echo "Aucun utilisateur trouvé avec cette adresse e-mail.";
        }

        $conn->close();
    }
}
?>
