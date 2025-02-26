<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

// Connexion à la base de données
$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    // Filtrage et validation des données entrées par l'utilisateur
    $title = htmlspecialchars($_POST['title']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);

    // Gestion sécurisée du fichier image téléchargé
    if (isset($_FILES['image'])) {
        $image = $_FILES['image']['name'];
        $target = "../images/" . basename($image);

        // Vérifier le type de fichier et la taille pour éviter les téléchargements malveillants
        $imageFileType = strtolower(pathinfo($target, PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        $maxFileSize = 5 * 1024 * 1024; // 5 MB

        if (in_array($imageFileType, $allowedTypes) && $_FILES['image']['size'] <= $maxFileSize) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                // Récupérer le contenu de TinyMCE
                $description = $_POST['description']; // Ne pas utiliser htmlspecialchars ici

                // Préparer et exécuter l'insertion dans la base de données
                $stmt = $conn->prepare("INSERT INTO actualites (title, start_date, end_date, image, description) VALUES (?, ?, ?, ?, ?)");
                $stmt->bind_param("sssss", $title, $start_date, $end_date, $image, $description);

                if ($stmt->execute()) {
                    // Redirection avec un message de succès
                    header('Location: admin_actualites.php?message=Actualité%20ajoutée%20avec%20succès');
                    exit();
                } else {
                    echo "Erreur: " . $stmt->error;
                }
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        } else {
            echo "Type de fichier non pris en charge ou taille de fichier trop grande.";
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }
}
?>
