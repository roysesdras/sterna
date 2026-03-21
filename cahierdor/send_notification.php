<?php
require_once 'includes/db.php';

// Clé serveur de Firebase (⚠️ à ne jamais partager publiquement)
define('FIREBASE_SERVER_KEY', 'koHkx3BhPFv3MUMHDBeuPRUijApClWhGEfjw18xBv5k');

function sendPushNotification($title, $body) {
    global $pdo;

    // Récupère tous les tokens
    $stmt = $pdo->query("SELECT token FROM notification_tokens");
    $tokens = $stmt->fetchAll(PDO::FETCH_COLUMN);

    if (empty($tokens)) return;

    $data = [
        "registration_ids" => $tokens, // plusieurs tokens
        "notification" => [
            "title" => $title,
            "body" => $body,
            "icon" => "/icone.png"
        ]
    ];

    $headers = [
        "Authorization: key=" . FIREBASE_SERVER_KEY,
        "Content-Type: application/json"
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://fcm.googleapis.com/fcm/send");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
