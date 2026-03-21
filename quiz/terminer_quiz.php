<?php
// 1. Démarrer le tampon pour capturer d'éventuels espaces ou warnings
ob_start();

// 2. Forcer le header JSON
header('Content-Type: application/json');

require_once '../config/db.php';
session_start();

$response = ['status' => 'error', 'message' => 'Erreur inconnue'];

if (!isset($_SESSION['animateur_id'])) {
    $response = ['status' => 'error', 'message' => 'Session expirée'];
} else {
    try {
        $animateur_id = $_SESSION['animateur_id'];

        // Marquer la session comme terminée
        $update = $conn->prepare("UPDATE quiz_sessions SET termine = 1 WHERE animateur = ? AND termine = 0");
        $update->bind_param("i", $animateur_id);
        $update->execute();
        $update->close();

        // Marquer les parties comme terminées
        $update_partie = $conn->prepare("UPDATE parties_quiz SET termine = 1 WHERE animateur_id = ? AND termine = 0");
        $update_partie->bind_param("i", $animateur_id);
        $update_partie->execute();
        $update_partie->close();

        $response = ['status' => 'success'];
    } catch (Exception $e) {
        $response = ['status' => 'error', 'message' => $e->getMessage()];
    }
}

// 3. Effacer tout ce qui a pu être généré (espaces, erreurs PHP) avant
ob_clean();

// 4. Envoyer uniquement le JSON
echo json_encode($response);
exit;
