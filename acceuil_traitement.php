<?php
// Récupération des données du formulaire
// Récupération des données du formulaire
$numero= $_POST['numero'];
$libelle = $_POST['libelle'];
$instruction = $_POST['instruction'];
$date = $_POST['date']=date("d/m/y");
$commentaire = $_POST['commentaire'];
$statut = $_POST['statut'];


// Connexion à la base de données
$connexion = new PDO('mysql:host=localhost;dbname=base', 'root', '');


// Insertion de l'utilisateur dans la base de données
$stmt = $connexion->prepare('INSERT INTO demande (libelle, instruction, date, commentaire, statut) VALUES (?, ?, ?,?,?)');
$stmt->execute(array($_POST['libelle'], $_POST['instruction'], $_POST['date'],$_POST['commentaire'],'En traitement'));




// Redirection vers la page de connexion
header('Location: demande.php');


// Rechargement de la page en 3 seconde
header("refresh: 3"); 
exit();
?>
