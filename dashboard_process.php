
<?php
// Récupération de la variable de session
session_start();
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur =  $_SESSION['user_name'];
$prenons_utilisateur =  $_SESSION['user_prename'];
$direction_utilisateur =$_SESSION['user_direction'];
$habilitation = $_SESSION['habilitation'];

include('config/dbconnect.php');
/// REQUETE DIRECTION AGENT ///
$req_direction_agent = "SELECT sigle FROM direction WHERE code = $direction_utilisateur";
$result = $connexion->query($req_direction_agent);


if ($result->num_rows > 0) {
    // Récupérer la valeur du libellé
    $row = $result->fetch_assoc();
    $libelleDirection = $row['sigle'];

} else {
  
}
 
 // Fermer la connexion à la base de données

// Récupération des données du formulaire

$numero= $_POST['numero'];
$libelle = $_POST['libelle'];
$instruction = $_POST['instruction'];
$date = $_POST['date']=Date("d/m/y");
$commentaire = $_POST['commentaire'];
$statut = $_POST['statut'];


// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=base', 'root', '');


// Insertion de l'utilisateur dans la base de données
$stmt = $connexion->prepare('INSERT INTO demande (libelle, instruction, date, commentaire, statut,etat,id_users) VALUES (?,?, ?, ?,?,?,?)');
$stmt->execute(array($_POST['libelle'], $_POST['instruction'], $_POST['date'], $_POST['commentaire'],'En traitement',1,$id_utilisateur));


/// recuperer le dernier enregistrement

$dernierID = $connexion->lastInsertId();


/// insertion du ou des fichiers dans le dossier upload
if(isset($_FILES['file'])) {
    $file_array = $_FILES['file'];


  
    foreach($file_array['name'] as $key => $name) {
     $tmp_name = $file_array['tmp_name'][$key];
     $destination = 'uploads/' . $libelleDirection . '/Attente/' . $dernierID . '-' . $name;


     move_uploaded_file($tmp_name, $destination);
    }
  }

/// enregistrement dans la table document
$stmt12 = $connexion->prepare('INSERT INTO document (lien, doc_demande) VALUES (?,?)');
$stmt12->execute(array($destination, $dernierID));

// Redirection vers la page de connexion
header('Location: demande.php');

exit();
?>
