<?php
// Activer l'affichage des erreurs
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Vérifie si l'email est valide
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Connexion à la base de données
        $servername = "localhost";
        $username = "u694220522_sterna_africa";
        $password = "@sterna_Africa225";
        $dbname = "u694220522_africa_db";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Vérification de la connexion
        if ($conn->connect_error) {
            die("Connexion échouée : " . $conn->connect_error);
        }

        // Génération d'un jeton unique pour la confirmation
        $token = bin2hex(random_bytes(16)); // Un jeton de 32 caractères hexadécimaux
        $status = 0; // Par défaut, l'utilisateur n'est pas confirmé
        $date_inscription = date('Y-m-d H:i:s'); // Date et heure d'inscription

        // Utilisation d'une requête préparée pour éviter les injections SQL
        $stmt = $conn->prepare("INSERT INTO abonnes (email, date_inscription, confirmé, token) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $email, $date_inscription, $status, $token);

        if ($stmt->execute()) {
            // Préparation du lien de confirmation
            $confirmation_link = "https://sternaafrica.org/confirmation.php?email=" . urlencode($email) . "&token=" . urlencode($token);

            // Préparation de l'email de confirmation
            $to = $email;
            $subject = "Confirmation d'inscription à la newsletter";
            $message_body = "Merci de vous être inscrit à notre newsletter. Veuillez cliquer sur le lien suivant pour confirmer votre inscription : <a href='$confirmation_link'>$confirmation_link</a>";
            $headers = "From: newsletter@sternaafrica.org\r\n";
            $headers .= "Reply-To: sternaafrica@gmail.com\r\n";
            $headers .= "Content-type: text/html; charset=UTF-8\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();

            // Envoi de l'email de confirmation
            if (mail($to, $subject, $message_body, $headers)) {
                $message = "<p class='success'>Merci de vous être abonné à notre newsletter ! Veuillez vérifier votre boîte de réception pour confirmer votre inscription.</p>";
            } else {
                $message = "<p class='error'>Erreur lors de l'envoi de l'email de confirmation.</p>";
            }
        } else {
            $message = "<p class='error'>Erreur lors de l'insertion dans la base de données : " . $stmt->error . "</p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        $message = "<p class='error'>Email invalide, veuillez réessayer.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de l'abonnement</title>
</head>
<body>
    <?php echo $message; ?>
</body>
</html>
