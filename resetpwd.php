<?php
include('header&footer/header_co.php');
?>
<link rel="stylesheet" type="text/css" href="css/pwd.css">
<!-- Ajoutez le CSS nécessaire pour styliser le formulaire -->

<!-- Formulaire à plusieurs étapes -->
<form id="regForm" action="traitement.php" method="post">
    <!-- Étape 1 -->
    <div class="tab">
    <div id="error-message" class="error-message"></div>
        <p><input type="email" name="email" placeholder="email..." oninput="this.className = ''" required class="form-control"></p>
    </div>

    <!-- Étape 2 -->
    <div class="tab">
    <div id="error-message" class="error-message"></div>
        <p><input type="text" name="token" placeholder="code..." oninput="this.className = ''" required class="form-control"></p>
    </div>

    <!-- Étape 3 -->
    <div class="tab">
    <div id="error-message" class="error-message"></div>
        <p><input type="password" name="new_password" placeholder="mot de passe..." oninput="this.className = ''" required class="form-control"></p>
        <p><input type="password" name="confirm_password" placeholder="confirmer le mot de passe..." oninput="this.className = ''" required class="form-control"></p>
    </div>

       <!-- Étape 4 (Récapitulatif) -->
       <div class="tab">
        <h2>Récapitulatif</h2>
        <p>Email: <span id="summaryEmail"></span></p>
        <p>Code: <span id="summaryToken"></span></p>
        <p>Mot de passe: <span id="summaryPassword"></span></p>
    </div>

    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="button" id="prevBtn" onclick="nextPrev(-1)">Précédant</button>
            <button type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
        </div>
    </div>

    <!-- Indicateurs d'étape -->
    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>
<script src="js/pwd.js"></script>
<!-- Ajoutez le script JavaScript nécessaire pour gérer le formulaire -->

<?php
include('header&footer/footer.php');
?>
