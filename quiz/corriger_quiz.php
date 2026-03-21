<?php
require_once '../config/db.php';

// On récupère toutes les réponses des participants non encore corrigées
$sql = "
    SELECT rp.id, rp.participant_id, rp.question_id, rp.reponse_id, r.est_correct
    FROM reponses_participants_quiz rp
    JOIN reponse_quiz r ON rp.reponse_id = r.id
";
$res = $conn->query($sql);

$points = [];

while ($row = $res->fetch_assoc()) {
    $pid = $row['participant_id'];
    $qid = $row['question_id'];
    if (!isset($points[$pid][$qid])) $points[$pid][$qid] = 0;
    if ($row['est_correct']) $points[$pid][$qid] += 1;
}

// Calcul total des points
foreach ($points as $pid => $questions) {
    $total = 0;
    foreach ($questions as $qid => $score) {
        $total += ($score > 0) ? 10 : 0; // barème simple
    }
    $conn->query("UPDATE participants_quiz SET score = $total WHERE id = $pid");
}
echo "Correction terminée ✅";
