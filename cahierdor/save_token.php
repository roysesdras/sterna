<?php
require_once 'includes/db.php'; // ta connexion PDO

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'] ?? '';
    $user_id = !empty($_POST['user_id']) ? (int)$_POST['user_id'] : null;

    if (!empty($token)) {
        // Pour éviter d'insérer des doublons, on extrait l'endpoint de l'abonnement
        $subData = json_decode($token, true);
        $endpoint = $subData['endpoint'] ?? $token;

        // Rechercher si l'abonnement existe déjà dans la base
        // (soit par token identique, soit par endpoint contenu dans le token)
        $stmtCheck = $pdo->prepare("SELECT id FROM notification_tokens WHERE token = :token OR token LIKE :endpoint");
        $stmtCheck->execute([
            'token' => $token,
            'endpoint' => '%' . $endpoint . '%'
        ]);
        $existing = $stmtCheck->fetch();

        if ($existing) {
            // Mettre à jour l'user_id si besoin
            if ($user_id !== null) {
                $stmtUpdate = $pdo->prepare("UPDATE notification_tokens SET user_id = :user_id WHERE id = :id");
                $stmtUpdate->execute([
                    'user_id' => $user_id,
                    'id' => $existing['id']
                ]);
            }
        } else {
            // Créer un nouvel enregistrement
            $stmt = $pdo->prepare("INSERT INTO notification_tokens (user_id, token) VALUES (:user_id, :token)");
            $stmt->execute([
                'user_id' => $user_id,
                'token' => $token
            ]);
        }

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Abonnement/Token manquant']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide']);
}
exit();
