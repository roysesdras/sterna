<?php
header('Content-Type: application/json');
require_once '../config/db.php';
session_start();

// 🔒 Vérif session animateur
if (!isset($_SESSION['animateur_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non autorisé']);
    exit;
}

$animateur_id = (int) $_SESSION['animateur_id'];

// 🔹 Étape 1 : récupérer la dernière partie non terminée
$stmt = $conn->prepare("
    SELECT id, question_actuelle, questions_lancees
    FROM quiz_sessions 
    WHERE animateur = ? AND termine = 0 
    ORDER BY id DESC 
    LIMIT 1
");
$stmt->bind_param("i", $animateur_id);
$stmt->execute();
$stmt->bind_result($partie_id, $question_id, $questions_lancees);
$stmt->fetch();
$stmt->close();

$participants = [];

if (!empty($partie_id)) {
    // 🔹 Étape 2 : récupérer les participants
    $pstmt = $conn->prepare("
        SELECT id, pseudo, a_repondu 
        FROM participants 
        WHERE animateur_id = ? AND session_id = ?
    ");
    $pstmt->bind_param("ii", $animateur_id, $partie_id);
    $pstmt->execute();
    $res = $pstmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $participants[$row['id']] = [
            'id'        => $row['id'],
            'pseudo'    => $row['pseudo'],
            'a_repondu' => (int) $row['a_repondu'],
            'reponse'   => null,
            'statut'    => '⏳ En attente'
        ];
    }
    $pstmt->close();

    // 🔹 Étape 3 : si une question est en cours, mettre à jour les statuts
    if (!empty($question_id)) {
        $rstmt = $conn->prepare("
            SELECT rp.participant_id, r.reponse, r.correcte 
            FROM reponses_participants_quiz rp
            LEFT JOIN reponse_quiz r ON rp.reponse_id = r.id
            WHERE rp.partie_id = ? AND rp.question_id = ?
        ");
        $rstmt->bind_param("ii", $partie_id, $question_id);
        $rstmt->execute();
        $res = $rstmt->get_result();

        while ($row = $res->fetch_assoc()) {
            if (isset($participants[$row['participant_id']])) {
                $participants[$row['participant_id']]['reponse'] = $row['reponse'];

                if ($participants[$row['participant_id']]['a_repondu'] == 1) {
                    $participants[$row['participant_id']]['statut'] =
                        $row['correcte'] ? '✅ OK' : '❌ Mauvaise réponse';
                }
            }
        }
        $rstmt->close();
    }
}

// 🔹 Étape 4 : renvoyer le JSON
echo json_encode([
    'status'             => 'ok',
    'partie_id'          => $partie_id ?? null,
    'question_lancee'    => $question_id ?? null,
    'questions_lancees'  => (int) ($questions_lancees ?? 0), // ✅ Ajout du compteur ici
    'joueurs'            => array_values($participants)
], JSON_UNESCAPED_UNICODE);
