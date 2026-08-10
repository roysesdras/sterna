<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . '/../../config/db.php';
    
    // Fallback if the connection is not made through db.php for some reason
    if (!isset($conn) || $conn->connect_error) {
        $conn = new mysqli("db", "root", "SoftiP24", "africa_db");
    }

    $nom = $_POST['nom'];
    $slug = $_POST['slug'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $uploadDir = __DIR__ . '/../../images/projets/';
    
    // Fonction d'upload
    function uploadImage($fileInputName, $uploadDir) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$fileInputName]['tmp_name'];
            $fileName = basename($_FILES[$fileInputName]['name']);
            // Nettoyer le nom du fichier
            $fileName = preg_replace("/[^a-zA-Z0-9\.\-_]/", "", $fileName);
            $fileName = time() . '_' . $fileName;
            
            if (move_uploaded_file($tmpName, $uploadDir . $fileName)) {
                return $fileName;
            }
        }
        return null;
    }

    $image_main = uploadImage('image_main', $uploadDir);
    $image_2 = uploadImage('image_2', $uploadDir);
    $image_3 = uploadImage('image_3', $uploadDir);

    $stmt = $conn->prepare("INSERT INTO projets (nom, slug, description, image_main, image_2, image_3) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nom, $slug, $description, $image_main, $image_2, $image_3);

    if ($stmt->execute()) {
        header("Location: admin_projets.php");
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
