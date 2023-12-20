<?php
// On initialise les variables de saisie avec des valeurs vides
$login = '';
$password = '';

// On vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On récupère les informations saisies par l'utilisateur
    $login = $_POST['username'];
    $password = $_POST['password'];

    include('config/dbconnect.php');

    /// DEBUT AUTHENTIFICATION///
    
    // Variables de connexion (remplacez-les par vos valeurs)
    
    
    // Requête SQL pour vérifier les informations de connexion
    $query = "SELECT * FROM Utilisateur WHERE username=? AND password=?";
    $stmt = $connexion->prepare($query);
    $stmt->bind_param("ss", $login, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user) {
        // Si les informations de connexion sont correctes, on crée une session et on redirige l'utilisateur vers la page d'accueil
        session_start();
        $_SESSION['user_id'] = $user['matricule'];
        $_SESSION['user_role'] = $user['habilitation'];
        $_SESSION['user_name'] = $user['nom'];
        $_SESSION['user_prename'] = $user['prenoms'];
        $_SESSION['user_direction'] = $user['direction_users'];
        $_SESSION['user_role'] = $user['habilitation'];
    
//verifie si le users est déja connecter
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
            // Afficher un message SweetAlert
            $sweetAlertMessage = 'Vous êtes déjà connecté.';
            exit();
        }else{
            $_SESSION['loggedin'] = true;
    
    
            // Redirection vers la page demande.php
            header("Location: demande.php");
            $connexion_reussie = true;
        
        $_POST['username']="";
        $_POST['password']="";
        
        
        }
        // Après la validation des informations d'identification
    // et la création de la session, définir la variable de session
    exit();
    } else {
        // Si les informations de connexion sont incorrectes, on affiche un message d'erreur
        $error_message = '<div class="alert alert-danger" align="center" role="alert">Login ou mot de passe incorrect.</div>';
        $loginError = true;
        $passwordError = true;
        $connexion_reussie = false;
    }
 
}

// On affiche le formulaire de connexion
?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<?php require_once('header&footer/header_co.php'); ?>

<main class="container">
  <div class="mb-3 d-flex justify-content-center">
  <div class="col-md-4">
    <div class="card border border-4 border-gray">
        <div class="card-body">
        <div class="text-center mb-4 animate__animated animate__pulse" style="animation-delay: 0.2s; animation-duration: 1s;">
  <i class="fas fa-user fa-5x"></i>
</div> <?php if (isset($sweetAlertMessage)) : ?>
        <script>
            swal("Déjà connecté", "<?php echo $sweetAlertMessage; ?>", "info").then(function() { window.location = "authentification.php"; });
        </script>
    <?php endif; ?>
                <?php if (isset($error_message)) : ?>
                    <?php echo $error_message; ?>
                <?php endif; ?>
                <form action="authentification.php" method="post">
                <div class="mb-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.4s; animation-duration: 1s;">
                <div class="input-group">
            
            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        <input type="text" class="form-control <?php if ($loginError) echo 'is-invalid'; ?>" id="username" name="username" placeholder="login" value="<?php echo $login; ?>" required>
                        <?php if ($loginError) : ?>
                            <div class="invalid-feedback"></div>
                            <!--div class="invalid-feedback">Erreur de Login</div-->
                        <?php endif; ?>
                    </div>
                </div>

                    <div class="mb-3 animate__animated animate__fadeInRight" style="animation-delay: 0.6s; animation-duration: 1s;"></div>
                    <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input type="password" class="form-control <?php if ($passwordError) echo 'is-invalid'; ?>" id="password" name="password" placeholder="mot de passe" required>
                        <?php if ($passwordError) : ?>
                            <div class="invalid-feedback"></div>
                            <!--div class="invalid-feedback">Mot de passe incorrect</div-->
                        <?php endif; ?>
                    </div>
                        </div>
                    <div class="mb-3">
                        <center><button type="submit" class="btn btn-primary btn-lg" style="font-size: 20px;">Connectez-vous</button></center>
                    </div>
                    <div class="mb-3 d-flex justify-content-center">
    <!-- Lien vers la page d'inscription avec message au survol de la souris -->
    <a href="inscription.php" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="S'inscrire ici">
        <i class="fa fa-user-plus fa-2x"></i>
    </a>
    <!-- Icône pour le lien de récupération de mot de passe -->
    <a href="recuperation_mdp.php" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Mot de passe oublier">
        <i class="fa fa-key fa-2x"></i></a>
</div>

                </form>
                </div>
    </div>
    </div>
</div>
	</main>
<script>          
$(function () {
    // Activation des tooltips Bootstrap
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<?php require_once('header&footer/footer.php'); ?>
