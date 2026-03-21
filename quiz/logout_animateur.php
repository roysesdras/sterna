<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
require_once '../config/db.php'; // connexion $conn

if (isset($_SESSION['animateur_id'])) {
    $animateur_id = $_SESSION['animateur_id'];

    // Récupérer l'ID de la dernière session
    $stmt = $conn->prepare("
        SELECT id FROM quiz_sessions
        WHERE animateur = ?
        ORDER BY id DESC
        LIMIT 1
    ");
    $stmt->bind_param("i", $animateur_id);
    $stmt->execute();
    $stmt->bind_result($last_session_id);
    $stmt->fetch();
    $stmt->close();

    // Si une session existe, on la marque comme terminée
    if (!empty($last_session_id)) {
        $stmt = $conn->prepare("UPDATE quiz_sessions SET termine = 1 WHERE id = ?");
        $stmt->bind_param("i", $last_session_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Détruire la session
session_unset();
session_destroy();

// Rediriger vers la page de connexion
header("Location: animateur_login.php");
exit;
