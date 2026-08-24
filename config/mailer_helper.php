<?php
// mailer_helper.php
require_once __DIR__ . '/mailer_config.php';
require_once dirname(__DIR__) . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_newsletter_notification($conn, $subject, $body_html) {
    if (SMTP_PASS === 'MOT_DE_PASSE_APPLICATION_ICI') {
        error_log("Envoi d'e-mail annulé : Le mot de passe SMTP n'est pas configuré.");
        return false;
    }

    // Récupérer les abonnés
    $abonnes = [];
    $res = $conn->query("SELECT email FROM abonnes WHERE confirmé = 1");
    if ($res && $res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
            if (filter_var($row['email'], FILTER_VALIDATE_EMAIL)) {
                $abonnes[] = $row['email'];
            }
        }
    }

    if (empty($abonnes)) {
        return false; // Personne à qui envoyer
    }

    $mail = new PHPMailer(true);
    try {
        // Paramètres du serveur
        $mail->isSMTP();
        $mail->Host       = SMTP_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = SMTP_USER;
        $mail->Password   = SMTP_PASS;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = SMTP_PORT;
        $mail->CharSet    = 'UTF-8';

        // Expéditeur
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);

        // Envoyer en Cci (BCC) pour cacher les adresses des autres abonnés
        $mail->addAddress(SMTP_FROM_EMAIL, SMTP_FROM_NAME);

        foreach ($abonnes as $email) {
            $mail->addBCC($email);
        }

        // Contenu
        $mail->isHTML(true);
        $mail->Subject = $subject;
        
        // Wrap body with Sterna styles
        $full_html = "
        <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; background: #f9fafb; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;'>
            <div style='background: #034890; padding: 20px; text-align: center;'>
                <h1 style='color: #ffffff; margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px;'>Sterna <span style='color: #fcb900;'>Africa</span></h1>
            </div>
            <div style='padding: 30px; background: #ffffff; color: #333333; line-height: 1.6;'>
                " . $body_html . "
            </div>
            <div style='background: #f3f4f6; padding: 15px; text-align: center; color: #6b7280; font-size: 12px;'>
                Vous recevez cet e-mail car vous êtes abonné à notre newsletter.<br>
                Sterna Africa - Wherever Needed
            </div>
        </div>";

        $mail->Body = $full_html;
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Erreur d'envoi de mail : {$mail->ErrorInfo}");
        return false;
    }
}
?>
