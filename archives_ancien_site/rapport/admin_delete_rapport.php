<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "DELETE FROM rapports WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin_rapports.php?message=Rapport supprimé avec succès");
    } else {
        die("Erreur de suppression : " . $conn->error);
    }
} else {
    header("Location: admin_rapports.php");
}
exit();
