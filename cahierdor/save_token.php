<?php
require_once 'includes/db.php'; // ta connexion PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $user_id = $_POST['user_id'] ?? null;

    if (!empty($token)) {
        $stmt = $pdo->prepare("INSERT INTO notification_tokens (user_id, token) VALUES (:user_id, :token)");
        $stmt->execute([
            'user_id' => $user_id,
            'token' => $token
        ]);

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Token manquant']);
    }
}
