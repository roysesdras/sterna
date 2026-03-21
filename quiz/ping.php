<?php
require_once '../config/db.php';
session_start();

if (isset($_SESSION['participant_id'])) {
    $participant_id = (int) $_SESSION['participant_id'];

    $stmt = $conn->prepare("
        UPDATE participants
        SET dernier_ping = NOW(), connecte = 1
        WHERE id = ?
    ");
    $stmt->bind_param("i", $participant_id);
    $stmt->execute();
    $stmt->close();

    echo json_encode(['status' => 'ok']);
} else {
    echo json_encode(['status' => 'no_session']);
}
