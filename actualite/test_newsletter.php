<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. Récupère le nom d'utilisateur système de ton hébergement
// Souvent c'est quelque chose comme u694220522
$user_system = get_current_user();
$host = $_SERVER['HTTP_HOST'];

// 2. On construit une adresse que le serveur ne peut pas rejeter
$from = "admin@" . $host;

$to = "softip12@gmail.com"; // TON EMAIL ICI
$subject = "Test de secours Sterna Africa";
$message = "Si ce mail arrive, c'est que le serveur accepte l'envoi via l'adresse système.";

// 3. En-têtes minimalistes mais corrects
$headers = "From: Sterna Africa <$from>\r\n";
$headers .= "Reply-To: sternaafrica@gmail.com\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo "✅ TEST RÉUSSI ! Le serveur a enfin accepté d'envoyer le mail.";
} else {
    echo "❌ ÉCHEC. Le serveur bloque strictement la fonction mail().";
    echo "<br>Détail de l'expéditeur tenté : " . $from;
}
