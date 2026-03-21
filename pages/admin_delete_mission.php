<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Sélectionner la mission pour récupérer le nom du fichier vidéo, s'il existe
    $sql_select = "SELECT video FROM missions WHERE id=?";
    $stmt = $conn->prepare($sql_select);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($video);
    $stmt->fetch();

    // Supprimer la mission de la base de données
    $sql_delete = "DELETE FROM missions WHERE id=?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        // Supprimer le fichier vidéo associé s'il existe
        if (!empty($video)) {
            $video_path = "../videos/" . $video;
            if (file_exists($video_path)) {
                unlink($video_path);
            }
        }

        header('Location: ../admin_dashboard.php?message=Mission%20supprimée%20avec%20succès');
    } else {
        echo "Erreur: " . $stmt->error;
    }
} else {
    echo "ID non fourni.";
}

$conn->close();
?>
