<?php
require_once '../inclusion/db.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    
    if ($id > 0) {
        // Supprimer d'abord les questions associées au module
        $stmt1 = $pdo->prepare("DELETE FROM questions WHERE module_id = ?");
        $stmt1->execute([$id]);

        // Ensuite supprimer le module
        $stmt2 = $pdo->prepare("DELETE FROM modules WHERE id = ?");
        $success = $stmt2->execute([$id]);

        echo json_encode(['success' => $success]);
    } else {
        echo json_encode(['success' => false, 'error' => 'ID invalide']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Méthode non autorisée']);
}
