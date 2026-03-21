<?php
// load_discussion.php
require_once 'inclusion/db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(400);
    echo "<p class='text-red-500'>ID de discussion invalide.</p>";
    exit;
}

$discussion_id = (int)$_GET['id'];

try {
    // Récupération des messages depuis la colonne `contenu`
    $req = $pdo->prepare("
        SELECT m.contenu, m.date_envoi, u.prenom, u.nom
        FROM forum_messages m
        JOIN users u ON m.auteur_id = u.id
        WHERE m.topic_id = ?
        AND m.contenu IS NOT NULL
        ORDER BY m.date_envoi ASC
    ");
    $req->execute([$discussion_id]);
    $messages = $req->fetchAll();

    if (empty($messages)) {
        echo "<p class='text-gray-400 text-center'>Aucun message pour cette discussion.</p>";
    } else {
        foreach ($messages as $msg) {
            echo "<div class='bg-gray-100 dark:bg-gray-700 rounded-lg px-4 py-2'>";
            echo "<p class='font-semibold text-sm text-blue-600 dark:text-blue-300'>" . htmlspecialchars($msg['prenom'] . ' ' . $msg['nom']) . "</p>";
            echo "<p class='text-sm my-1'>" . nl2br(htmlspecialchars($msg['contenu'])) . "</p>";
            echo "<p class='text-xs text-gray-500 mt-1'>" . date('d/m/Y H:i', strtotime($msg['date_envoi'])) . "</p>";
            echo "</div>";
        }
    }
} catch (Exception $e) {
    http_response_code(500);
    echo "<p class='text-red-500'>Erreur lors du chargement des messages.</p>";
}
?>
