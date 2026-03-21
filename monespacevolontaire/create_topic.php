<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

header('Content-Type: application/json');
session_start();

require_once './inclusion/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Méthode invalide']);
    exit;
}

$titre = trim($_POST['titre'] ?? '');
$message = trim($_POST['message'] ?? '');
$categorie_id = (int)($_POST['categorie_id'] ?? 0);
$categorie_nom = trim($_POST['categorie_nom'] ?? '');
$user_id = $_SESSION['user_id'] ?? null;
$auteur = $_SESSION['user_nom'] ?? 'Moi';

if (!$titre || !$message || !$categorie_id || !$user_id) {
    echo json_encode(['success' => false, 'message' => 'Champs requis manquants']);
    exit;
}

try {
    // 1. Insérer le nouveau topic
    $stmt = $pdo->prepare("INSERT INTO forum_topics (titre, auteur_id, categorie_id, date_creation) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$titre, $user_id, $categorie_id]);
    $topic_id = $pdo->lastInsertId();

    // 2. Ajouter le message initial lié au topic
    $stmt = $pdo->prepare("INSERT INTO forum_messages (topic_id, auteur_id, message, date_envoi) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$topic_id, $user_id, $message]);

    // 3. Répondre en JSON
    echo json_encode([
        'success' => true,
        'topic_id' => $topic_id,
        'titre' => htmlspecialchars($titre),
        'auteur' => htmlspecialchars($auteur),
        'date' => date('d M Y'),
        'categorie' => htmlspecialchars($categorie_nom),
        'message' => htmlspecialchars(mb_substr($message, 0, 120)) . '...'
    ]);
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur BDD : ' . $e->getMessage()]);
}
exit;
