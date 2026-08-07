<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once __DIR__ . '/../../config/db.php';
    
    // Fallback if the connection is not made through db.php for some reason
    if (!isset($conn) || $conn->connect_error) {
        $conn = new mysqli("db", "root", "SoftiP24", "africa_db");
    }

    $nom = $conn->real_escape_string($_POST['nom']);
    $slug = $conn->real_escape_string($_POST['slug']);

    $stmt = $conn->prepare("INSERT INTO projets (nom, slug) VALUES (?, ?)");
    $stmt->bind_param("ss", $nom, $slug);

    if ($stmt->execute()) {
        header("Location: admin_projets.php");
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
