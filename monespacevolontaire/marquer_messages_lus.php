<?php
session_start();
require 'inclusion/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    echo json_encode(['status' => 'unauthorized']);
    exit;
}

$volontaire_id = $_SESSION['user_id'];

// Récupérer tous les messages
$stmt = $pdo->prepare("SELECT id FROM messages_globaux");
$stmt->execute();
$messages = $stmt->fetchAll(PDO::FETCH_COLUMN);

if (!$messages) {
    echo json_encode(['status' => 'no_messages']);
    exit;
}

// Marquer chaque message comme lu s’il n’est pas encore marqué
$checkStmt = $pdo->prepare("SELECT COUNT(*) FROM messages_lus WHERE volontaire_id = ? AND message_id = ?");
$insertStmt = $pdo->prepare("INSERT INTO messages_lus (volontaire_id, message_id, date_lecture) VALUES (?, ?, NOW())");

foreach ($messages as $message_id) {
    $checkStmt->execute([$volontaire_id, $message_id]);
    if ($checkStmt->fetchColumn() == 0) {
        $insertStmt->execute([$volontaire_id, $message_id]);
    }
}

echo json_encode(['status' => 'ok']);
exit;
