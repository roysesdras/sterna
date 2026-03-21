<?php
require_once 'inclusion/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(403);
    exit("Utilisateur non connecté.");
}

if (empty($_POST['discussion_id']) || empty($_POST['message'])) {
    http_response_code(400);
    exit("Paramètres manquants.");
}

$discussion_id = (int)$_POST['discussion_id'];
$message = trim($_POST['message']);
$auteur_id = (int)$_SESSION['user_id'];

try {
    $req = $pdo->prepare("INSERT INTO forum_messages (topic_id, auteur_id, contenu) VALUES (?, ?, ?)");
    $req->execute([$discussion_id, $auteur_id, $message]);

    http_response_code(200); // Tout va bien, mais on n'affiche rien
} catch (Exception $e) {
    http_response_code(500);
    echo "Erreur serveur : " . $e->getMessage();
}
