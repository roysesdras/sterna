<?php
require_once 'includes/db.php';
session_start();

header('Content-Type: application/json');

// Vérification de sécurité
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    echo json_encode(['success' => false, 'error' => 'Accès refusé. Vous devez être administrateur.']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment_id'])) {
    $comment_id = (int)$_POST['comment_id'];

    if ($comment_id <= 0) {
        echo json_encode(['success' => false, 'error' => 'ID de commentaire invalide.']);
        exit();
    }

    try {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = ?");
        $result = $stmt->execute([$comment_id]);

        if ($result) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'error' => 'Échec de la suppression.']);
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => 'Erreur de base de données : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Requête invalide.']);
}
exit();
