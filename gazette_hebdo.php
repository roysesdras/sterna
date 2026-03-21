<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Chemin vers l'autoload de Composer
require_once 'config/db.php';   // Ton fichier de connexion

// 1. RÉCUPÉRER LES ACTUALITÉS NON ENVOYÉES
$queryNews = "SELECT id, title, description, image, lieu FROM actualites WHERE envoye_newsletter = 0";
$resultNews = $conn->query($queryNews);

if ($resultNews->num_rows === 0) {
    die("Aucune nouvelle actualité à envoyer aujourd'hui.");
}

// 2. PRÉPARER LE CONTENU HTML DE LA GAZETTE
$articlesHtml = "";
$newsIds = [];

while ($row = $resultNews->fetch_assoc()) {
    $newsIds[] = $row['id'];
    $lien = "https://sternaafrica.org/actualite/" . $row['id'];
    $imagePath = $row['image'] ? "https://sternaafrica.org/images/" . $row['image'] : "https://sternaafrica.org/assets/img/logo.png";

    // On coupe la description pour le résumé (150 caractères)
    $resume = substr(strip_tags($row['description']), 0, 150) . "...";

    $articlesHtml .= "
        <div style='margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 20px;'>
            <img src='$imagePath' style='width: 100%; max-width: 500px; border-radius: 10px;'>
            <h2 style='color: #333;'>{$row['title']}</h2>
            <p style='color: #666; font-style: italic;'>📍 {$row['lieu']}</p>
            <p style='color: #444; line-height: 1.6;'>$resume</p>
            <a href='$lien' style='display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;'>Lire l'article complet</a>
        </div>";
}

// 3. RÉCUPÉRER LES ABONNÉS CONFIRMÉS
$queryAbonnes = "SELECT email FROM abonnes WHERE confirmé = 1";
$resultAbonnes = $conn->query($queryAbonnes);

if ($resultAbonnes->num_rows > 0) {
    $mail = new PHPMailer(true);

    try {
        // CONFIGURATION SERVEUR GOOGLE SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mail.sternaafrica@gmail.com'; // <--- TON EMAIL
        $mail->Password   = 'dhne ojcj zhio ilbf ';    // <--- TON CODE JAUNE
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->setFrom('mail.sternaafrica@gmail.com', 'Sterna Africa');
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // ENVOI AUX ABONNÉS
        while ($abonne = $resultAbonnes->fetch_assoc()) {
            $mail->clearAddresses();
            $mail->addAddress($abonne['email']);

            $mail->Subject = "✨ Les dernières nouvelles de Sterna Africa";

            // Le corps du mail (Template)
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto;'>
                    <div style='text-align: center; background: #1a1a1a; padding: 20px;'>
                         <h1 style='color: white;'>Sterna Africa</h1>
                    </div>
                    <div style='padding: 20px;'>
                        <p>Bonjour,</p>
                        <p>Voici ce qu'il s'est passé récemment sur nos antennes :</p>
                        $articlesHtml
                    </div>
                    <div style='text-align: center; font-size: 12px; color: #999; padding: 20px;'>
                        Vous recevez ce mail car vous êtes inscrit à la newsletter de Sterna Africa.<br>
                        <a href='https://sternaafrica.org/desinscription.php?email=" . $abonne['email'] . "'>Se désabonner</a>
                    </div>
                </div>";

            $mail->send();
        }

        // 4. MARQUER LES ACTUALITÉS COMME ENVOYÉES
        $idsList = implode(',', $newsIds);
        $conn->query("UPDATE actualites SET envoye_newsletter = 1 WHERE id IN ($idsList)");

        echo "Gazette envoyée avec succès à " . $resultAbonnes->num_rows . " abonnés.";
    } catch (Exception $e) {
        echo "Erreur lors de l'envoi : {$mail->ErrorInfo}";
    }
}
