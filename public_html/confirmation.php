<?php
// Connexion à la base de données
$servername = "localhost"; 
$username = "u694220522_sterna_africa"; 
$password = "@sterna_Africa225"; 
$dbname = "u694220522_africa_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données.");
}

// Vérifier si le token est présent dans l'URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Préparer la requête pour vérifier le token
    $stmt = $conn->prepare("SELECT * FROM abonnes WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Le token est valide, confirmer l'inscription
        $stmtUpdate = $conn->prepare("UPDATE abonnes SET confirmé = 1 WHERE token = ?");
        $stmtUpdate->bind_param("s", $token);
        
        if ($stmtUpdate->execute()) {
            echo "Votre inscription a été confirmée avec succès ! Merci de vous être inscrit à notre newsletter.";
        } else {
            echo "Une erreur est survenue lors de la confirmation de votre inscription. Veuillez réessayer plus tard.";
        }
        
        $stmtUpdate->close();
    } else {
        echo "Token invalide ou déjà utilisé.";
    }

    $stmt->close();
} else {
    echo "Aucun token fourni.";
}

$conn->close();
?>
