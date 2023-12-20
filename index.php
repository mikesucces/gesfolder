
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
<?php
 include('header&footer/header_co.php');
?>

<script>

$(document).ready(function() {
  // Récupération du message d'erreur depuis PHP
  var errorMessage = "<?php echo isset($error_message) ? $error_message : ''; ?>";
  
  if (errorMessage !== '') {
    // Affichage du message d'erreur au-dessus des champs de connexion
    var errorHtml = '<div class="alert alert-danger">' + errorMessage + '</div>';
    $('.col-md-3').prepend(errorHtml);
  }
});
</script>

<main class="container">
  <div class="mb-3 d-flex justify-content-center animate__animated animate__fadeIn" style="animation-delay: 0.5s; animation-duration: 1.5s;">
    <div class="col-md-4">
      <div class="card border border-4 border-gray animate__animated animate__fadeIn" style="background-color:orange;animation-delay: 0.5s; animation-duration: 1s;">
        <div class="card-body">
        <div class="text-center mb-4 animate__animated animate__pulse" style="animation-delay: 0.2s; animation-duration: 1s;">
  <i class="fas fa-user fa-5x"></i>
</div>
        
          <form action="authentification.php" method="post">
          <div class="mb-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.4s; animation-duration: 1s;">
          <div class="input-group">
            
                  <span class="input-group-text"><i class="fas fa-user"></i></span>
                
                <input type="text" class="form-control" id="username" name="username" placeholder="Login" required>
              </div>
            </div>

            <div class="mb-3 animate__animated animate__fadeInRight" style="animation-delay: 0.6s; animation-duration: 1s;">
              <div class="input-group">
                
                  <span class="input-group-text"><i class="fas fa-lock"></i></span>
                
                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
              </div>
            </div>
            <div class="mb-3 d-flex justify-content-center animate__animated animate__fadeInUp" style="animation-delay: 0.8s; animation-duration: 1s;">
              <button type="submit" onmouseover="this.style.color='white'" onmouseout="this.style.color=''" class="btn btn-primary btn-lg" style="font-size: 20px;">Connectez-vous</button>
            </div>
            <div class="mb-3 d-flex justify-content-center animate__animated animate__fadeIn" style="animation-delay: 1s; animation-duration: 1s;">
              <!-- Lien vers la page d'inscription avec message au survol de la souris -->
              <a href="inscription.php" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="S'inscrire ici" style="animation-duration: 1s; color: green;">
               <b>S'inscrire</b>
                </a>

              <!-- Icône pour le lien de récupération de mot de passe -->
              <a href="resetpwd.php" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Mot de passe oublié" style="animation-duration: 1s;color: green;">
              <b>Mot de passe oublié</b>
                </a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script>
$(function () {
    // Activation des tooltips Bootstrap
    $('[data-toggle="tooltip"]').tooltip();
});
</script>
<?php
 include('header&footer/footer_co.php');
?>