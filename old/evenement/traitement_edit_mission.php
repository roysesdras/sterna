<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin/admin_login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

if (isset($_POST['submit'])) {
    $id = intval($_POST['id']);
    
    // Filtrage et validation
    $title = htmlspecialchars($_POST['title']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    $lieu = htmlspecialchars($_POST['lieu']);
    $video = isset($_POST['video']) ? htmlspecialchars($_POST['video']) : NULL;
    $description = $_POST['description']; // Ne pas filtrer TinyMCE/Summernote ici

    // Récupérer l'image existante si aucune nouvelle n'est uploadée
    $stmt_img = $conn->prepare("SELECT image FROM missions WHERE id = ?");
    $stmt_img->bind_param("i", $id);
    $stmt_img->execute();
    $result_img = $stmt_img->get_result();
    if ($result_img->num_rows === 0) {
        die("Activité introuvable.");
    }
    $row_img = $result_img->fetch_assoc();
    $image_to_save = $row_img['image'];
    $stmt_img->close();

    // Gestion de la nouvelle image si elle est téléchargée
    if (isset($_FILES['image']) && $_FILES['image']['size'] > 0) {
        $image = $_FILES['image']['name'];
        $ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        $new_image_name = uniqid('mission_') . '.' . $ext;
        $target = "../../images/" . $new_image_name;

        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'webp');
        $maxFileSize = 2000 * 1024; // 2 MB

        if (in_array($ext, $allowedTypes) && $_FILES['image']['size'] <= $maxFileSize) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                $image_to_save = $new_image_name; // Mettre à jour avec la nouvelle image
                // Optionnel: Supprimer l'ancienne image si elle existe
                if (!empty($row_img['image']) && file_exists("../../images/" . $row_img['image'])) {
                    unlink("../../images/" . $row_img['image']);
                }
            } else {
                die("Erreur lors du téléchargement de la nouvelle image.");
            }
        } else {
            if ($_FILES['image']['size'] > $maxFileSize) {
                die("Fichier trop lourd (Maximum 2 Mo).");
            } else {
                die("Type de fichier non pris en charge.");
            }
        }
    }

    // Mise à jour de la base de données
    $stmt = $conn->prepare("UPDATE missions SET title = ?, start_date = ?, end_date = ?, image = ?, lieu = ?, video = ?, description = ? WHERE id = ?");
    $stmt->bind_param("sssssssi", $title, $start_date, $end_date, $image_to_save, $lieu, $video, $description, $id);

    if ($stmt->execute()) {
        header('Location: ../admin/admin_dashboard.php?message=Activité%20mise%20à%20jour%20avec%20succès');
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }
}
?>
