<?php
ob_start();
header('Content-Type: application/json');
require_once '../config/db.php';
session_start();

$animateur_id = $_SESSION['animateur_id'] ?? 0;

try {
    if ($animateur_id === 0) {
        throw new Exception("Animateur non identifié");
    }

    // Requête précise basée sur vos tables
    $query = "
        SELECT 
            p.pseudo, 
            COUNT(rpq.id) as reponses_correctes,
            (COUNT(rpq.id) * 10) as score_total 
        FROM participants p
        -- On lie les réponses envoyées par les participants
        INNER JOIN reponses_participants_quiz rpq ON p.id = rpq.participant_id
        -- On lie à la table des réponses pour vérifier si elles sont correctes
        INNER JOIN reponse_quiz rq ON rpq.reponse_id = rq.id
        WHERE p.animateur_id = ? 
        AND rq.correcte = 1
        GROUP BY p.id
        ORDER BY score_total DESC, p.pseudo ASC
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $animateur_id);
    $stmt->execute();
    $resultats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    ob_clean();
    echo json_encode($resultats);
} catch (Exception $e) {
    ob_clean();
    echo json_encode([]);
}
exit;
