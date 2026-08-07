<?php
require_once 'includes/db.php';

header('Content-Type: application/json');

$entryId = isset($_GET['entry_id']) ? (int)$_GET['entry_id'] : 0;

if ($entryId <= 0) {
    echo json_encode(['comments' => [], 'total' => 0]);
    exit;
}

$stmt = $pdo->prepare("SELECT id, pseudo, comment, created_at FROM comments WHERE entry_id = ? ORDER BY created_at ASC");
$stmt->execute([$entryId]);
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Total
$total = count($comments);

echo json_encode([
    'comments' => $comments,
    'total' => $total
]);
exit;
