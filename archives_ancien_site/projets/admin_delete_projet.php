<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if (isset($_GET['id'])) {
    $conn = new mysqli("db", "root", "SoftiP24", "africa_db");
    if (!$conn->connect_error) {
        $id = intval($_GET['id']);
        // Delete project
        $stmt = $conn->prepare("DELETE FROM projets WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        // Also set projet_id to NULL in actualites for this project to avoid broken links
        $stmt2 = $conn->prepare("UPDATE actualites SET projet_id = NULL WHERE projet_id = ?");
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        
        $conn->close();
    }
}
header("Location: admin_projets.php");
exit();
?>
