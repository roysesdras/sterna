<?php
//delete question
require_once '../config/db.php';
session_start();

// Vérification session admin
if (!isset($_SESSION['admin_quiz_id'])) {
    header("Location: login");
    exit;
}

// Vérifier que l'ID est fourni
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("❌ ID de question manquant.");
}

$id = intval($_GET['id']);

// 🔹 Supprimer les réponses associées
$stmt = $conn->prepare("DELETE FROM reponse_quiz WHERE question_id = ?");
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("❌ Erreur lors de la suppression des réponses : " . $stmt->error);
}
$stmt->close();

// 🔹 Supprimer la question elle-même
$stmt = $conn->prepare("DELETE FROM question_quiz WHERE id = ?");
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("❌ Erreur lors de la suppression de la question : " . $stmt->error);
}
$stmt->close();

// 🔹 Redirection vers le dashboard
header("Location: dashboard#question");
exit;
