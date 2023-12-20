<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />



<script>
$(document).ready(function() {
  $('#username').on('blur', function() {
    var username = $(this).val();
    
    if (username !== '') {
      $.ajax({
        url: 'verification_login.php',
        type: 'POST',
        data: { username: username },
        dataType: 'json',
        success: function(response) {
          if (response.exists) {
            // Login déjà utilisé, afficher un message d'erreur
            $('#username').addClass('is-invalid');
            $('#username-error').text('Ce login est déjà utilisé.');
          } else {
            // Login disponible, retirer le message d'erreur
            $('#username').removeClass('is-invalid');
            $('#username-error').text('');
          }
        }
      });
    }
  });
});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<?php
 include('header&footer/header_co.php');
?>

<main class="container animate__animated animate__fadeIn"style="margin-top:-40px">
  <div class="container my-5 animate__animated animate__fadeIn" >
    <div class="row justify-content-center animate__animated animate__fadeIn">
      <div class="col-md-4 animate__animated animate__fadeIn" style="animation-delay: 0.2s; animation-duration: 1s;">
        <div class="card border border-4 border-gray animate__animated animate__fadeIn" style="background-image: url('fond2.jpg');background-size: cover;  background-repeat: no-repeat;animation-delay: 0.2s; animation-duration: 1s;">
          <div class="card-body">
          <div class="text-center mb-4 animate__animated animate__pulse" style="animation-delay: 0.2s; animation-duration: 1s;">
  <i class="fas fa-users fa-5x"></i>
</div>
            <form action="inscription_process.php" method="post">
              <div class="mb-3 animate__animated animate__fadeInLeft" style="animation-delay: 0.6s; animation-duration: 1s;">
                <select class="form-control" id="direction" name="direction" required>
                  <option value="" disabled selected hidden>Clique ici pour choisir une direction</option>
                  <?php
                  // Connexion à la base de données
                  $connexion = new PDO('mysql:host=localhost;dbname=base', 'root', '');

                  // Requête pour récupérer les directions
                  $query = "SELECT * FROM direction";
                  $result = $connexion->query($query);

                  // Parcourir les enregistrements et générer les options du menu déroulant
                  while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='" . $row['code'] . "'>" . $row['sigle'] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="mb-3 animate__animated animate__fadeInRight" style="animation-delay: 0.8s; animation-duration: 1s;">
                <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" required>
              </div>
              <div class="mb-3 animate__animated animate__fadeInLeft" style="animation-delay: 1s; animation-duration: 1s;">
                <input type="text" class="form-control" id="prenoms" name="prenoms" placeholder="Prénoms" required>
              </div>
              <div class="mb-3 animate__animated animate__fadeInRight" style="animation-delay: 1.2s; animation-duration: 1s;">
                <input type="text" class="form-control" id="username" name="username" placeholder="Login" required>
              </div>
              <div class="mb-3 animate__animated animate__fadeInLeft" style="animation-delay: 1.4s; animation-duration: 1s;">
                <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
              </div>
              <div class="mb-3 animate__animated animate__fadeInUp" style="animation-delay: 1.6s; animation-duration: 1s;">
                <center><button type="submit" class="btn btn-primary btn-lg" onmouseover="this.style.color='white'" onmouseout="this.style.color=''" style="font-size: 20px;">Inscrivez-vous</button></center>
              </div>
              <div class="mb-3 d-flex justify-content-center animate__animated animate__fadeIn" style="animation-delay: 1s; animation-duration: 1s; ">
              <!-- Lien vers la page d'inscription avec message au survol de la souris -->
              <a href="index.php" class="btn btn-link" data-toggle="tooltip" data-placement="top" title="Connexion" style="animation-duration: 1s;color:green;">
              <b>Connexion</b>
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
  </div>
</main>

	<!-- Liens vers les fichiers JavaScript -->
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>

  <?php
 include('header&footer/footer_co.php');
?>