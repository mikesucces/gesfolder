
<?php
include('config/header_acceuil.php');
?>
<main>
<body>
   
    <center><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ajouterLigne">
 Nouvelle demande</button></center>
 <div>&nbsp</div>
    <table id="tableau" class="display custom-table" style="width:100%">
        <thead>
            <tr>
            
                <th>Libelle</th>
				<th>Instruction</th>
				<th>Fichier</th>
                <th>Commentaire</th>
				<th>Statut</th>
				<th>Actions</th> 
            </tr>
        </thead>
        <tbody>
       
        </tbody>
    </table>
    <div class="modal fade" id="ajouterLigne" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">

   
       <h1 class="modal-title fs-5" id="exampleModalLabel">Ajouter une ligne</h1>
       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      

     </div>

     <div class="modal-body dropzone">
     <form action="acceuil_traitement.php" method="post"></form>
    <div class="mb-5">
    
    <input type="text" class="form-control" id="libelle" name="libelle" placeholder="libelle" required>
  </div> 

  <div class="mb-5">
    
    <input type="textarea" class="form-control" id="instruction" name="instruction" placeholder="instruction" required>
  </div> 
  
  <div classclass="mb-5">
    
  <div class="dropzone" id="files" name="files" class="dz-default dz-message dropZoneDragArea"></div><br>
    
  </div> 
      </div>


    <div class="modal-footer">
              <input type="hidden" name="Id" id="Id" />
    					<input type="hidden" name="action" id="action" value="" />
        <button type="button" id="ajouter" class="btn btn-primary">Ajouter</button>
        <button type="button" class="btn btn-secondary" id="fermer" data-bs-dismiss="modal">Fermer</button>
      </div>
</div>

    </div>

  </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script src="js/coran.js"></script>
    </form>
    </main>   
<?php
 include('config/footer.php');
?>
