<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: dashboard#categorie");
    exit;
}

$id = (int) $_GET['id'];

// Vérifie que la catégorie existe
$stmt = $conn->prepare("SELECT id FROM categorie_quiz WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows === 0) {
    header("Location: dashboard#categorie");
    exit;
}

// Supprime la catégorie
$delete = $conn->prepare("DELETE FROM categorie_quiz WHERE id = ?");
$delete->bind_param("i", $id);

if ($delete->execute()) {
    $_SESSION['success_message'] = "Catégorie supprimée avec succès ✅";
} else {
    $_SESSION['error_message'] = "Erreur lors de la suppression.";
}

header("Location: dashboard#categorie");
exit;
