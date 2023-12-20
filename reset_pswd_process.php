<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';

// Assurez-vous que l'e-mail est défini
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // Étape 1 : Générer le jeton (implémentez votre propre logique)
    $token = generateToken();

    // Étape 1 : Envoyer l'e-mail avec le jeton en utilisant PHPMailer
    sendTokenEmail($email, $token);

    // Rediriger vers l'étape suivante
    header("Location: index.php?etape=2");
    exit();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'])) {
    // ... (le reste de votre code reste inchangé)
}

// Fonction pour envoyer l'e-mail avec le jeton en utilisant PHPMailer
function sendTokenEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP (à adapter selon vos besoins)
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com';  // Spécifiez votre serveur SMTP
        $mail->SMTPAuth   = true;
        $mail->Username   = 'votre@email.com';  // Spécifiez votre adresse e-mail SMTP
        $mail->Password   = 'votre_mot_de_passe';  // Spécifiez votre mot de passe SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinataire et expéditeur
        $mail->setFrom('votre@email.com', 'Votre Nom');
        $mail->addAddress($email);

        // Contenu de l'e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Token';
        $mail->Body    = 'Your password reset token is: ' . $token;

        // Envoyer l'e-mail
        $mail->send();
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}

// Le reste de votre code reste inchangé...
