<?php
// Configuration pour afficher les erreurs - à désactiver en production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Déclaration de l'en-tête JSON
header('Content-Type: application/json');

// Connexion à la base de données
$servername = "localhost";
$username = "u694220522_sterna_africa";
$password = "@sterna_Africa225";
$dbname = "u694220522_africa_db";

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur de connexion à la base de données.']);
    exit();
}

// Vérification si la requête est POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Adresse e-mail invalide.']);
        exit();
    }

    $email = $conn->real_escape_string($email);
    $date_inscription = date('Y-m-d H:i:s');
    $token = bin2hex(random_bytes(16)); // Générer un token unique

    // Vérifier si l'email est déjà dans la base
    $checkEmailQuery = $conn->prepare("SELECT * FROM abonnes WHERE email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $result = $checkEmailQuery->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Cette adresse e-mail est déjà abonnée.']);
    } else {
        // Insertion de l'email dans la base de données
        $stmt = $conn->prepare("INSERT INTO abonnes (email, date_inscription, confirmé, token) VALUES (?, ?, 0, ?)");
        $stmt->bind_param("sss", $email, $date_inscription, $token);

        if ($stmt->execute()) {
            // Envoi de l'email de confirmation
            $subject = "Confirmation de votre abonnement";
            $message = "Bonjour,\n\nNous apprécions votre abonnement à notre newsletter.\nVeuillez confirmer en cliquant sur ce lien : ";
            $message .= "\n\nhttps://sternaafrica.org/confirmation.php?token=" . $token;
            $message .= "\n\nNous sommes ravis de vous compter parmi nous ! \n\nEn confirmant votre abonnement, vous serez le premier à recevoir nos actualités et offres exclusives.";

            $headers = "From: sternaafrica@gmail.com\r\n" .
                       "Reply-To: sternaafrica@gmail.com\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            if (mail($email, $subject, $message, $headers)) {
                echo json_encode(['status' => 'success', 'message' => "Un e-mail de confirmation a été envoyé à $email. Merci de le confirmer."]);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Erreur lors de l\'envoi de l\'e-mail.']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Une erreur est survenue. Veuillez réessayer.']);
        }

        $stmt->close();
    }

    $checkEmailQuery->close();
}

$conn->close();
