<?php
session_start();
$id_utilisateur = $_SESSION['user_id'];
$nom_utilisateur = $_SESSION['user_name'];
$prenons_utilisateur = $_SESSION['user_prename'];
$direction_utilisateur = $_SESSION['user_direction'];
$habilitation = $_SESSION['user_role'];

include('config/dbconnect.php');

$sqlSelect = "SELECT sigle FROM direction WHERE code = '$direction_utilisateur'";
$result = $connexion->query($sqlSelect);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $libelleDirection = $row['sigle'];
} else {
    // Gérer le cas où la requête ne renvoie aucun résultat
}

$numero = $_POST['id'];

$stmt1 = "UPDATE demande SET statut = 'Transmis', etat='1' WHERE numero = $numero";
$result1 = $connexion->query($stmt1);

if ($result1 === TRUE) {
    $dernierID1 = $numero;
    $fichiersAjoutes = 0;

    if (isset($_FILES['file'])) {
        $file_array = $_FILES['file'];

        foreach ($file_array['name'] as $key => $name) {
            $file_name = $file_array['name'][$key];
            $file_tmp = $file_array['tmp_name'][$key];
            $file_size = $file_array['size'][$key];
            $file_type = $file_array['type'][$key];
            $file_error = $file_array['error'][$key];
        
            $destination = 'uploads/' . $libelleDirection . '/Attente/' . $dernierID1 . '-' .$file_name;

            if ($file_error === UPLOAD_ERR_OK) {
                move_uploaded_file($file_tmp, $destination);
                $stmt12 = $connexion->prepare("UPDATE document SET lien = :destination WHERE id = :dernierID1");

                if ($stmt12 !== FALSE) {
                    $stmt12->bindParam(':destination', $destination);
                    $stmt12->bindParam(':dernierID1', $dernierID1);
                    $stmt12->execute();

                    if ($stmt12->rowCount() > 0) {
                        $fichiersAjoutes++;
                    } else {
                        echo "Aucune ligne n'a été affectée par la requête d'update.";
                    }
                }
            }
        }
}
        if ($fichiersAjoutes > 0) {
            $message1 = "La demande a été transmise au gestionnaire.";
            $style = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: green; padding: 40px; font-size: 36px; text-align: center;';
            echo '<div style="' . $style . '" class="animate__animated animate__heartBeat">' . $message1 . '</div>';
            header("refresh:1; url=demande.php");
            exit();
        } else {
          $message1 = "La demande a été transmise au gestionnaire.";
          $style = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: green; padding: 40px; font-size: 36px; text-align: center;';
          echo '<div style="' . $style . '" class="animate__animated animate__heartBeat">' . $message1 . '</div>';
          header("refresh:1; url=demande.php");
          exit();
        }
    
} else {
  $message1 = "La demande a été transmise au gestionnaire.";
  $style = 'position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: orange; color: green; padding: 40px; font-size: 36px; text-align: center;';
  echo '<div style="' . $style . '" class="animate__animated animate__heartBeat">' . $message1 . '</div>';
  header("refresh:1; url=demande.php");
  exit();
}
?>
