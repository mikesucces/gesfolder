<?php
ini_set('post_max_size', '10G');
if(isset($_SERVER['CONTENT_LENGTH']) && isset($_POST) && intval($_SERVER['CONTENT_LENGTH'])>0 && count($_POST)===0)
	echo ini_get('post_max_size');

if(isset($_POST["valider"])){
	if(intval($_SERVER['CONTENT_LENGTH'])>0 && count($_POST)===0){
    throw new Exception('PHP discarded POST data because of request exceeding post_max_size.');
}
print_r($_FILES);

die("zzzzzzzzzzzz aa");
}
?>
<form method="post"  enctype="multipart/form-data">
      <br>
<div class="mb-3">
    <input type="file" class="form-control" id="fileInput" name="file[]" multiple />
    <small class="form-text text-muted">Taille maximale des fichiers : 10 Mo.</small>
</div>
            <!-- SCRIPT POUR AFFICHER LE NOM DES FICHIERS SELECTIONNER   -->
            <script>

        document.querySelector('input[name="file[]"]').addEventListener('change', function (event) {
            var files = event.target.files;
            var fileList = "";

            for (var i = 0; i < files.length; i++) {
                fileList += files[i].name + "<br>";
            }

            document.getElementById('fileList').innerHTML = fileList;
        });
    </script>

            <div id="fileList"></div>
            <!-- FIN -->
<br>
      <button type="submit" class="btn btn-primary" name="valider">Valider</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>

    </div>
  </div>
</div>

</form>