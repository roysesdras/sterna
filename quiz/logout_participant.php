<?php
require_once '../config/db.php';
session_start();

if (isset($_SESSION['participant_id'])) {
    $participant_id = (int) $_SESSION['participant_id'];

    // Marquer le joueur comme déconnecté
    $stmt = $conn->prepare("UPDATE participants SET connecte = 0 WHERE id = ?");
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $stmt->close();
}

// Supprimer toutes les variables de session
session_unset();
session_destroy();

// Redirection vers la page de connexion
header("Location: participant-connect");
exit;
