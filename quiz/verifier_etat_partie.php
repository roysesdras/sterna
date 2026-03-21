<?php
require_once '../config/db.php';
session_start();

$participant_id = $_SESSION['participant_id'] ?? 0;
if (!$participant_id) {
    echo json_encode(['status' => 'error']);
    exit;
}

$partie_id = $_SESSION['partie_id'] ?? 0;

$stmt = $conn->prepare("SELECT termine FROM parties_quiz WHERE id = ?");
$stmt->bind_param("i", $partie_id);
$stmt->execute();
$stmt->bind_result($termine);
$stmt->fetch();
$stmt->close();

echo json_encode([
    'status' => 'ok',
    'termine' => $termine
]);
