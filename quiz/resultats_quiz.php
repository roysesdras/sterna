<?php
ob_start();

ini_set('display_errors', 0); // Désactivé pour éviter de casser le JSON
error_reporting(E_ALL);
header('Content-Type: application/json; charset=UTF-8');

require_once '../config/db.php';
session_start();

$partie_id = $_GET['partie_id'] ?? 0;
$participant_id = $_SESSION['participant_id'] ?? 0;

if (!$partie_id || !$participant_id) {
    echo json_encode(['termine' => false, 'message' => 'Session expirée ou partie invalide.']);
    exit;
}

// Vérifier si la partie est terminée
$stmt = $conn->prepare("SELECT termine FROM parties_quiz WHERE id = ?");
$stmt->bind_param("i", $partie_id);
$stmt->execute();
$stmt->bind_result($termine);
$found = $stmt->fetch();
$stmt->close();

if (!$found || (int)$termine !== 1) {
    echo json_encode(['termine' => false]);
    exit;
}

// 1. Score total réel du participant (déjà multiplié par 10 en base)
$stmt = $conn->prepare("SELECT score_total FROM scores_participants WHERE participant_id = ? AND partie_id = ?");
$stmt->bind_param("ii", $participant_id, $partie_id);
$stmt->execute();
$stmt->bind_result($score_total);
$stmt->fetch();
$stmt->close();
$score_total = (int)($score_total ?? 0);

// 2. Récupérer toutes les questions (pour calculer le score MAX possible)
$questions = [];
$qRes = $conn->query("SELECT id, question FROM question_quiz");
while ($row = $qRes->fetch_assoc()) {
    $questions[$row['id']] = [
        'texte' => stripslashes(htmlspecialchars_decode($row['question'], ENT_QUOTES)),
        'points' => 10 // On définit 10 points ici
    ];
}
$qRes->close();

// 3. Récupérer les bonnes réponses
$bonnes_reponses = [];
$rRes = $conn->query("SELECT question_id, reponse FROM reponse_quiz WHERE correcte = 1");
while ($row = $rRes->fetch_assoc()) {
    $bonnes_reponses[$row['question_id']][] = stripslashes(htmlspecialchars_decode($row['reponse'], ENT_QUOTES));
}
$rRes->close();

// 4. Récupérer les réponses du participant
$stmt = $conn->prepare("
    SELECT rp.question_id, rq.reponse 
    FROM reponses_participants_quiz rp
    JOIN reponse_quiz rq ON rq.id = rp.reponse_id
    WHERE rp.participant_id = ? AND rp.partie_id = ?
");
$stmt->bind_param("ii", $participant_id, $partie_id);
$stmt->execute();
$res = $stmt->get_result();

$reponses_participant = [];
while ($row = $res->fetch_assoc()) {
    $qid = $row['question_id'];
    $reponses_participant[$qid][] = stripslashes(htmlspecialchars_decode($row['reponse'], ENT_QUOTES));
}
$stmt->close();

// 5. Construire la liste des réponses détaillées
$details = [];
foreach ($questions as $qid => $qdata) {
    $choix = $reponses_participant[$qid] ?? [];
    if (empty($choix)) continue; // On ne montre que les questions auxquelles il a répondu

    $bonnes = $bonnes_reponses[$qid] ?? [];
    
    // Vérification de la justesse (toutes les bonnes réponses cochées et aucune mauvaise)
    sort($bonnes);
    sort($choix);
    $participant_correct = ($bonnes === $choix);

    $details[] = [
        'question_id' => $qid,
        'question_texte' => $qdata['texte'],
        'points' => 10,
        'correct' => $participant_correct,
        'choix_participant' => $choix,
        'bonne_reponses' => $bonnes
    ];
}

// ✅ CALCUL DU TOTAL_POINTS (Nombre de questions répondues * 10)
$total_points_max = count($details) * 10;

// 6. Classement général
$stmt = $conn->prepare("
    SELECT p.pseudo, s.score_total 
    FROM scores_participants s
    JOIN participants p ON p.id = s.participant_id
    WHERE s.partie_id = ?
    ORDER BY s.score_total DESC
");
$stmt->bind_param("i", $partie_id);
$stmt->execute();
$res = $stmt->get_result();

$classement = [];
while ($row = $res->fetch_assoc()) {
    $classement[] = [
        'nom' => $row['pseudo'],
        'score_total' => (int)$row['score_total']
    ];
}
$stmt->close();

ob_clean();
echo json_encode([
    'termine' => true,
    'score_total' => $score_total, // ex: 80
    'total_points' => $total_points_max, // ex: 100
    'reponses' => $details,
    'classement' => $classement
], JSON_UNESCAPED_UNICODE);