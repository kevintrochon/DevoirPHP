<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once 'include/PHPMailer/Exception.php';
require_once 'include/PHPMailer/PHPMailer.php';
require_once 'include/PHPMailer/SMTP.php';
function envoieMail($email,$attache){
    try {
        // configuration :
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Mailer = "smtp";
        $mail->SMTPOptions = array(
            'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
            )
            );
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Je veux debug
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'ssl'; // Gmail REQUIERT Le transfert
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;
        $mail->Charset="utf-8";
        $mail->Username = "kevintrochon9@gmail.com";
        $mail->Password = "y1oly2na";
        $mail->isHTML(true);
        $mail->addAddress($email);
        $mail->From = "kevintrochon9@gmail.com";
        $mail->Subject = "Document";
        $mail->addAttachment($attache);
        $mail->Body = "<p>Madame, Monsieur,</p> <p>Voici vos documents que vous trouverez en attachés.</p> <p>Cordialement,</p> <p>Noumea Hospital</p>";

        $mail->send();
        echo '<p class="alert alert-success" style="padding-left:350px;">E-mail envoyé !</p>';

    } catch (Exception $exception) {
        echo '<p class="alert alert-danger" style="padding-left:350px;">Le message n\'a pas pu être envoyé. Mailer Error: {$mail->ErrorInfo}</p>';
    }
}