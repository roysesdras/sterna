<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("db", "root", "SoftiP24", "africa_db");
    if ($conn->connect_error) die("Échec de la connexion : " . $conn->connect_error);

    $id = intval($_POST['id']);
    $nom = $conn->real_escape_string($_POST['nom']);
    $slug = $conn->real_escape_string($_POST['slug']);

    $stmt = $conn->prepare("UPDATE projets SET nom = ?, slug = ? WHERE id = ?");
    $stmt->bind_param("ssi", $nom, $slug, $id);

    if ($stmt->execute()) {
        header("Location: admin_projets.php");
    } else {
        echo "Erreur : " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
}
?>
