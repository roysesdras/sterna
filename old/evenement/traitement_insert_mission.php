<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin/admin_login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

if (isset($_POST['submit'])) {
    // Filtrage et validation des données entrées par l'utilisateur
    $title = htmlspecialchars($_POST['title']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $lieu = htmlspecialchars($_POST['lieu']);
    $video = isset($_POST['video']) ? htmlspecialchars($_POST['video']) : NULL;
    $description = $_POST['description']; // Ne pas filtrer TinyMCE/Summernote ici

    // Gestion sécurisée du fichier image téléchargé
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        // Generate a unique name to avoid overwriting
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $new_image_name = uniqid('mission_') . '.' . $ext;
        $target = "../../images/" . $new_image_name;

        // Vérifier le type et la taille du fichier
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $maxFileSize = 2000 * 1024; // 2 MB

        if (in_array($ext, $allowedTypes) && $_FILES['image']['size'] <= $maxFileSize) {
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                die("Erreur lors du téléchargement de l'image.");
            }
            $image_to_save = $new_image_name;
        } else {
            if ($_FILES['image']['size'] > $maxFileSize) {
                die("Fichier trop lourd (Maximum 2 Mo).");
            } else {
                die("Type de fichier non pris en charge.");
            }
        }
    } else {
        $image_to_save = NULL;
    }

    // Préparer et exécuter l'insertion dans la base de données
    $stmt = $conn->prepare("INSERT INTO missions (title, start_date, end_date, image, lieu, video, description) 
                            VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $title, $start_date, $end_date, $image_to_save, $lieu, $video, $description);

    if ($stmt->execute()) {
        header('Location: ../admin/admin_dashboard.php?message=Activité%20ajoutée%20avec%20succès');
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }
}
?>
