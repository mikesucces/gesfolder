
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


// Récupération de la variable de session
session_start();
/*set_time_limit(0);
ini_set('post_max_size', '10G');
ini_set('upload_max_filesize', '10G');*/

$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur =  $_SESSION['user_name'];
$prenons_utilisateur =  $_SESSION['user_prename'];
$direction_utilisateur =$_SESSION['user_direction'];
$habilitation = $_SESSION['user_role'];
$_SESSION['user_username'] = $user['user_username'];
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


$varef = $libelleDirection . '-' . date("Y-m-d");

$requete_insertion_demande = "INSERT INTO demande (libelle, instruction, date, commentaire, statut, etat, id_users, nature, delai, reference, date_publication, date_rejet, date_validation) VALUES (?, ?, STR_TO_DATE(?, '%d-%m-%Y'), ?, ?, ?, ?, ?, ?, ?, STR_TO_DATE(?, '%d-%m-%Y'), STR_TO_DATE(?, '%d-%m-%Y'), STR_TO_DATE(?, '%d-%m-%Y'))";
$stmt1 = $connexion->prepare($requete_insertion_demande);

$numero = $_POST['numero'];
$libelle = $_POST['libelle'];
$instruction = $_POST['instruction'];
$date = date("d-m-Y");
$commentaire = $_POST['commentaire'];
$statut = 'Transmis'; // Défini ici, ne répétez pas la définition
$nature = $_POST['nature'];
$delai = $_POST['delai'];
$etat = '1'; // Défini ici, ne répétez pas la définition
$reference = ''; // Défini ici, ne répétez pas la définition

$date_validation=date("d-m-Y");
$date_publication=date("d-m-Y");
$date_rejet=date("d-m-Y");
// Associer les valeurs aux paramètres de la requête
//$stmt1->bind_param("ssssssissssss", $libelle, $instruction, $date, $commentaire, $statut, $etat, $id_utilisateur, $nature, $delai, $reference,$date_publication,$date_rejet,$date_validation);


if ($stmt1) {
  // Associer les valeurs aux paramètres de la requête
  $stmt1->bind_param("ssssssissssss", $libelle, $instruction, $date, $commentaire, $statut, $etat, $id_utilisateur, $nature, $delai, $reference, $date_publication, $date_rejet, $date_validation);

  // Exécution de la requête
  if ($stmt1->execute()) {
   //   $dernierID = $connexion->lastInsertId();
   $query = "SELECT LAST_INSERT_ID() as last_id";
   $result = $connexion->query($query);
   
   if ($result) {
     $row = $result->fetch_assoc();
     $dernierID = $row['last_id'];
     $ref = $varef . '-' . $dernierID;

     $Update_demande = "UPDATE demande SET reference = ? WHERE numero = ?";
     $stmt2 = $connexion->prepare($Update_demande);

     // Associer les valeurs aux paramètres de la requête
     $stmt2->bind_param("si", $ref, $dernierID);

if ($stmt2->execute())  {
    // La référence a été mise à jour avec succès
   // echo "La référence a été mise à jour avec succès.";
} else {
    // Une erreur s'est produite lors de la mise à jour
   // echo "Erreur lors de la mise à jour de la référence : " . $stmt->errorInfo()[2];
}

  } else {
     //echo "Erreur lors de l'exécution de la requête : " . $stmt1->error;
  }

}

}


// Récupération des données du formulaire


$numero= $_POST['numero'];
$libelle = $_POST['libelle'];
$instruction = $_POST['instruction'];
$date = date("d-m-Y");
$commentaire = $_POST['commentaire'];
$statut = $_POST['statut'];
$nature = $_POST['nature'];
$delai = $_POST['delai'];


if(isset($_FILES['file'])) {
  $file_array = $_FILES['file'];

  foreach ($file_array['name'] as $key => $name) {
    $file_name = $file_array['name'][$key];
    $file_tmp = $file_array['tmp_name'][$key];
    $file_size = $file_array['size'][$key];
    $file_type = $file_array['type'][$key];
    $file_error = $file_array['error'][$key];

    $destination = 'uploads/' . $libelleDirection . '/Attente/' . $dernierID . '-' . $file_name;

    // Vérifier si le fichier a été téléchargé avec succès
    if ($file_error === UPLOAD_ERR_OK) {
      // Déplacer le fichier vers le dossier de destination
      move_uploaded_file($file_tmp, $destination);
      
$req_docuemnt = "INSERT INTO document (lien, doc_demande) VALUES (?, ?)";
$stmt3 = $connexion->prepare($req_docuemnt);

// Associer les valeurs aux paramètres de la requête
$stmt3->bind_param("si", $destination, $dernierID);

// Exécuter la requête d'insertion
if ($stmt3->execute()) {
    // L'insertion a réussi
   // echo "Insertion réussie.";
} else {
    // Une erreur s'est produite lors de l'insertion
   // echo "Erreur lors de l'insertion : " . $stmt->error;
}
    }
  }


  require 'phpqrcode/qrlib.php';

// Texte à inclure dans le QR code
$texteQRCode = 'DGBF';

// Chemin où enregistrer l'image du QR code pour la demande
$qrCodePathDemande = 'uploads/' . $libelleDirection . '/QRCODE/' . $ref . '_qrcode_demande.png';

// Générer le QR code pour la demande
QRcode::png($texteQRCode, $qrCodePathDemande, QR_ECLEVEL_L, 10);


// Maintenant, générez le PDF
require('fpdf/fpdf.php');

// Créer une instance de FPDF
$pdf = new FPDF();
$pdf->AddPage('P', 'A5'); // Format A5 (portrait)


// Ajouter du contenu au PDF (utilisez les données de la demande que vous venez d'enregistrer)
$pdf->SetFont('Arial', 'B', 20);
$pdf->Cell(0, 10, 'DEMANDE ' . $ref, 0, 1, 'C');
$pdf->Ln(10);


$pdf->SetFont('Arial', '', 16);
$pdf->Cell(0, 10, 'NATURE DE LA DEMANDE : ' . mb_convert_encoding($_POST['nature'], 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 10, 'OBJET : ' . mb_convert_encoding($_POST['libelle'], 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 10, 'DATE DE TRANSMISSION: ' . mb_convert_encoding($date, 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 10, 'DELAI D\'EXECUTION : ' . mb_convert_encoding($_POST['delai'], 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 10, 'DETAILS : ' . mb_convert_encoding($_POST['instruction'], 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Cell(0, 10, 'DIRECTION : ' . mb_convert_encoding($libelleDirection, 'ISO-8859-1', 'UTF-8'), 0, 1);
$pdf->Image($qrCodePathDemande, 10, $pdf->GetY(), 30, 30);
$pdf->Ln(40);

// Définir le nom du fichier PDF généré
//$nomFichierPDF = $ref . '.pdf';
$nomFichierPDF = 'uploads/' . $libelleDirection . '/pdf/' . $ref . '.pdf';

// Générer le PDF en tant que fichier
if ($pdf->Output($nomFichierPDF, 'F')) {
  echo 'Erreur lors de la génération du PDF.';
} else {
  echo 'PDF généré avec succès.';
  // Rediriger l'utilisateur vers le fichier PDF généré dans un nouvel onglet
  echo '<script>window.open("' . $nomFichierPDF . '", "_blank");</script>';
}


  // Envoi du PDF par email
  require 'PHPMailer/src/Exception.php';
  require 'PHPMailer/src/PHPMailer.php';
  require 'PHPMailer/src/SMTP.php';

  $mail = new PHPMailer(true);

  try {
      // Paramètres du serveur SMTP
      $mail->isSMTP();
      $mail->Host       = 'smtp.postmarkapp.com';  // Remplacez par l'adresse du serveur SMTP
      $mail->SMTPAuth   = true;
      $mail->Username   = '69c53c2f-2e24-4a0c-bc41-2a6c026d4c01'; // Remplacez par votre adresse email
      $mail->Password   = '69c53c2f-2e24-4a0c-bc41-2a6c026d4c01';
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
      $mail->Port       = 25;  // Port SMTP

      // Destinataire
      $mail->setFrom('info@dgbf.ci', 'DSIB / SOUS DRIRECTION EXPLOITATION / SERVICE DE COMMUNICATION NUMERIQUE');
      $mail->addAddress('arnaudkoffimichael@gmail.com', 'KOFFI Arnaud');
      
    

      // Pièce jointe
      $mail->addAttachment($nomFichierPDF);

      // Contenu du message
      $mail->isHTML(true);
      $mail->Subject = 'NOTIFICATION'.$ref;
      $mail->Body    = 'La demande '.$ref.' est enregistrée';

      // Envoyer l'email
      $mail->send();
      echo 'Email envoyé avec succès.';

 // Après l'envoi de l'email, redirigez l'utilisateur vers la page qui affiche le dossier sur Google Drive
    // Utilisez le lien partagé du dossier
   // $lienGoogleDriveDossier = 'https://drive.google.com/drive/folders/1-rPRYau0mEjgIT73v_wCWepOl2_Yw6lg';
  //  echo '<script>window.location.replace("' . $lienGoogleDriveDossier . '");</script>';
} catch (Exception $e) {
    echo "Erreur lors de l'envoi de l'email : {$mail->ErrorInfo}";
  }
}

?>
