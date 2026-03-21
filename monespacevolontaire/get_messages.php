<?php
//get_messages.php
session_start();
require_once './inclusion/db.php';

$user_id = $_SESSION['user_id'] ?? 0;
$discussion_id = intval($_GET['discussion_id'] ?? 0);

if ($discussion_id && $user_id) {
    $stmt = $pdo->prepare("SELECT m.id, m.contenu, m.auteur_id
                           FROM forum_messages m
                           WHERE m.discussion_id = ?
                           ORDER BY m.date_envoi ASC");
    $stmt->execute([$discussion_id]);
    $rawMessages = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Reformat pour le JS
    $messages = array_map(function ($msg) use ($user_id) {
        return [
            'message' => $msg['contenu'],
            'from_me' => $msg['auteur_id'] == $user_id
        ];
    }, $rawMessages);

    header('Content-Type: application/json');
    echo json_encode($messages);
} else {
    http_response_code(400);
    echo json_encode(['error' => 'ID discussion ou utilisateur manquant.']);
}
