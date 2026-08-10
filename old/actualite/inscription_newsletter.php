<?php
header('Content-Type: application/json');

$servername = "db";
$username = "root";
$password = "SoftiP24";
$dbname = "africa_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Erreur de connexion.']);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Adresse e-mail invalide.']);
        exit();
    }

    $email = $conn->real_escape_string($email);
    $date_inscription = date('Y-m-d H:i:s');

    // Vérifier si l'email existe déjà
    $checkEmailQuery = $conn->prepare("SELECT * FROM abonnes WHERE email = ?");
    $checkEmailQuery->bind_param("s", $email);
    $checkEmailQuery->execute();
    $result = $checkEmailQuery->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Vous êtes déjà inscrit !']);
    } else {
        // MODIFICATION : On met '1' directement dans la colonne 'confirmé'
        $stmt = $conn->prepare("INSERT INTO abonnes (email, date_inscription, confirmé) VALUES (?, ?, 1)");
        $stmt->bind_param("ss", $email, $date_inscription);

        if ($stmt->execute()) {
            // Optionnel : Envoyer quand même un petit mail de bienvenue (sans lien à cliquer)
            $subject = "Bienvenue chez Sterna Africa !";
            $message = "Bonjour,\n\nMerci de vous être abonné à notre newsletter. Vous recevrez désormais nos actualités directement ici.";

            $headers = "From: sternaafrica@gmail.com\r\n";
            mail($email, $subject, $message, $headers);

            echo json_encode(['status' => 'success', 'message' => "Merci ! Votre inscription est bien confirmée. 😊"]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Une erreur est survenue.']);
        }
        $stmt->close();
    }
    $checkEmailQuery->close();
}
$conn->close();
