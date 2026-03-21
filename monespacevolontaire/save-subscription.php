<?php
require './inclusion/db.php'; // adapte selon ton arborescence

header('Content-Type: application/json');

// Récupération des données JSON envoyées par le JS
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

if (
    !$data ||
    !isset($data['endpoint'], $data['keys']['p256dh'], $data['keys']['auth'])
) {
    http_response_code(400);
    echo json_encode(['error' => 'Abonnement invalide.']);
    exit;
}

$endpoint = $data['endpoint'];
$p256dh = $data['keys']['p256dh'];
$auth = $data['keys']['auth'];

// Vérifie si l'abonnement existe déjà
$stmt = $pdo->prepare("SELECT id FROM push_subscriptions WHERE endpoint = ?");
$stmt->execute([$endpoint]);

if ($stmt->rowCount() === 0) {
    // Insère l’abonnement
    $insert = $pdo->prepare("INSERT INTO push_subscriptions (endpoint, p256dh, auth) VALUES (?, ?, ?)");
    $insert->execute([$endpoint, $p256dh, $auth]);
}

echo json_encode(['success' => true]);
