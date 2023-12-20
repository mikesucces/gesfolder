<?php
include('header&footer/header_co.php');

// Vérification des champs obligatoires
if (!isset($_POST['nom']) || empty($_POST['nom']) ||
    !isset($_POST['prenoms']) || empty($_POST['prenoms']) ||
    !isset($_POST['username']) || empty($_POST['username']) ||
    !isset($_POST['password']) || empty($_POST['password'])  
) {
    header('Location: inscription.php?erreur=champs_obligatoires');
    exit();
}

// Récupération des valeurs du formulaire
$direction = $_POST['direction'];
$nom = $_POST['nom'];
$prenoms = $_POST['prenoms'];
$username = $_POST['username'];
$password = $_POST['password'];

// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=base', 'root', '');

// Vérification si le login existe déjà
$stmt = $connexion->prepare('SELECT COUNT(*) FROM utilisateur WHERE username = ?');
$stmt->execute([$username]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    $erreurMessage = "Le login est déjà utilisé.";
    echo '
        <script>
            swal({
                title: "Erreur d\'enregistrement",
                text: "'.$erreurMessage.'",
                icon: "error",
            }).then(function() {
                window.location.href = "inscription.php";
            });
        </script>
    ';
    include('header&footer/footer_co.php');
    exit();
}
else{




// Préparation de la requête d'insertion
$stmt = $connexion->prepare('INSERT INTO utilisateur (nom, prenoms, habilitation, username, password, direction_users) VALUES (?, ?, ?, ?, ?, ?)');

// Exécution de la requête avec les valeurs des champs de formulaire
$result = $stmt->execute([$nom, $prenoms, 'users', $username, $password, $direction]);
?>

<main class="container">
    <div class="container my-3">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Inscription</h1>

                <?php
                if ($result) {
                    $style = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: green; padding: 40px; font-size: 36px; text-align: center;';
                    $style1 = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: red; padding: 40px; font-size: 36px; text-align: center;';
                    // Afficher le message au milieu de la page avec animation
                    echo '<div style="' . $style . '" class="animate__animated animate__heartBeat">Le mot de passe à été changé </div>';
                    header("refresh:1; url=index.php");
                } else {
                    $erreurMessage = "L'enregistrement n'a pas pu être effectué.";
                    $style1 = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: green; padding: 40px; font-size: 36px; text-align: center;';
  
                    // Afficher le message au milieu de la page avec animation
                    echo '<div style="' . $style1 . '" class="animate__animated animate__heartBeat">Une erreur s\'est produite lors de l\'enregistrement</div>';
                    header("refresh:1; url=inscription.php");
                }

            }
                ?>

                <!-- Le reste du contenu de la page -->

            </div>
        </div>
    </div>
</main>

<?php
include('header&footer/footer_co.php');
?>
