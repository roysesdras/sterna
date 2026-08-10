<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("db", "root", "SoftiP24", "africa_db");
    if ($conn->connect_error) die("Échec de la connexion : " . $conn->connect_error);

    $id = intval($_POST['id']);
    $nom = $_POST['nom'];
    $slug = $_POST['slug'];
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $uploadDir = __DIR__ . '/../../images/projets/';
    
    function uploadImage($fileInputName, $uploadDir) {
        if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
            $fileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\.\-_]/", "", basename($_FILES[$fileInputName]['name']));
            if (move_uploaded_file($_FILES[$fileInputName]['tmp_name'], $uploadDir . $fileName)) {
                return $fileName;
            }
        }
        return null;
    }

    $updates = ["nom = ?", "slug = ?", "description = ?"];
    $types = "sss";
    $params = [&$nom, &$slug, &$description];

    $image_main = uploadImage('image_main', $uploadDir);
    if ($image_main) { $updates[] = "image_main = ?"; $types .= "s"; $params[] = &$image_main; }

    $image_2 = uploadImage('image_2', $uploadDir);
    if ($image_2) { $updates[] = "image_2 = ?"; $types .= "s"; $params[] = &$image_2; }

    $image_3 = uploadImage('image_3', $uploadDir);
    if ($image_3) { $updates[] = "image_3 = ?"; $types .= "s"; $params[] = &$image_3; }

    $query = "UPDATE projets SET " . implode(", ", $updates) . " WHERE id = ?";
    $types .= "i";
    $params[] = &$id;

    $stmt = $conn->prepare($query);
    
    // Bind parameters dynamically
    $bind_names = array_merge([$types], $params);
    call_user_func_array(array($stmt, 'bind_param'), $bind_names);

    if ($stmt->execute()) {
        header("Location: admin_projets.php");
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
