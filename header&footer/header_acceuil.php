
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Gestion de fichiers</title>
	<!-- Liens vers les fichiers CSS -->
	
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/acceuil.css">

	<script type="text/javascript" charset="utf8" src="js/coran.js"></script>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
  
<link rel="stylesheet" href="css/dropzone.css" type="text/css" />
<link rel="stylesheet" href="css/pagination.css" type="text/css" />
<style>
        .navbar-brand {
            font-size: 60px;
            font-family: 'Calipso MT', sans-serif; /* Utilisation de la police 'Cursive' */
           
        }

        footer {
            margin-top: auto; /* Permet au footer de rester en bas de la page */
        }
    </style>
</head>
<body>

<header class="py-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 p-0" style="margin-bottom: -130px">
                  <!--img src="DGBF.png" alt="Image de remplacement" class="img-fluid" style="width: 100%; height:50%"-->
                </div>
            </div>
        </div>
    </header>

<nav class="navbar navbar-expand-lg navbar-dark bg-secondary mb-3">
	<div class="container">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<!--ul class="navbar-nav me-auto mb-2 mb-lg-0">
				<li class="nav-item">
					<a class="nav-link" href="index.php"><i class="fa fa-home fa-3x"></i></a>
				</li>
			</ul-->
			<span class="navbar-brand mx-auto" style="font-size: 40px; font-family: 'Helvetica Neue', sans-serif;"><b>GESTION DE FICHIERS</b></span>
			<ul class="navbar-nav">
<li class="nav-item">
					<a class="nav-link user-link" href="#">
                        <i class="fa fa-user fa-2x"></i>
                    
						<div class="user-details">
							<span class="user-name"><?php echo $nom_utilisateur; ?></span>
							<span class="user-name"><?php echo $prenons_utilisateur; ?></span>
						</div>

						<div class="user-details">
							<span class="user-name"><?php echo $libelleDirection; ?></span>
						</div>
                        <div class="user-details">
                        <i class="fa fa-bars"></i>
						</div>

                        

		<div class="submenu" id="submenu">
        <ul>
            <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i> Profil</a></li>
            <li><a href="#"><i class="fa fa-cog" aria-hidden="true"></i> Modifier le mot de passe</a></li>
            <li><a href="#" onclick="javascrpit:deconnexion();"><i class="fa fa-power-off fa-1x"></i> Déconnexion</a></li>
        </ul>
        </div>

</li>

       
  
					</a>
					<style>
						.user-link {
							display: flex;
							align-items: center;
							text-decoration: none;
						}

						.user-details {
							margin-left: 10px;
						}

						.user-name {
							font-weight: bold;
						}

						.user-surname {
							color: gray;
						}

						.user-menu {
    position: relative;
    display: inline-block;
}

.user-link {
    display: flex;
    align-items: center;
    text-decoration: none;
    color: #fff;
}

.user-details {
    margin-left: 10px;
}

.user-name {
    font-weight: bold;
}

.user-surname {
    color: gray;
}

.submenu {
    display: none;
    position: absolute;
    top: 100%;
    right: 0;
    background-color: #fff;
    box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
    z-index: 1;
}

.submenu ul {
    list-style-type: none;
    padding: 0;
    margin: 0;
}

.submenu li {
    padding: 10px;
}

.submenu li a {
    text-decoration: none;
    color: #000;
}
					</style>
				
			<script>
				var userLink = document.querySelector(".user-link");
var submenu = document.getElementById("submenu");

userLink.addEventListener("click", function(event) {
    event.preventDefault();
    if (submenu.style.display === "none") {
        submenu.style.display = "block";
    } else {
        submenu.style.display = "none";
    }
});

document.addEventListener("click", function(event) {
    if (!userLink.contains(event.target)) {
        submenu.style.display = "none";
    }
});

			</script>
			</li>
			

				<li class="nav-item">
				

				</li>
			</ul>
		</div>
	</div>
</nav>

	 <!-- Deconnexion-->

	 <script>
function deconnexion() {
    // Affichez la boîte de dialogue de confirmation
 
    Swal.fire({
        title: 'Déconnexion',
        text: 'Êtes-vous sûr de vouloir vous déconnecter ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Oui',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            // Si l'utilisateur confirme, redirigez-le vers "deconnexion.php" pour effectuer la déconnexion
            window.location.href = 'deconnexion.php';
        }
    });
}
</script>

	