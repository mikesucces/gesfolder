<?php
include('config/verification.php');


 include('header&footer/header_acceuil.php');
?>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mt-5">Profile utilisateur</h1>
                <form>
                    <div class="mb-3">
                        <label for="username" class="form-label">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="username" value="JohnDoe" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" value="johndoe@example.com" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="fullname" class="form-label">Nom complet</label>
                        <input type="text" class="form-control" id="fullname" value="John Doe">
                    </div>
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Liens vers les fichiers JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
</body>


<?php
 include('header&footer/footer.php');
?>