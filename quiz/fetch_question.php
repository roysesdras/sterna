<?php
require_once '../config/db.php';
session_start();

// Vérifie que le participant est connecté
if (!isset($_SESSION['participant_id'])) {
    echo json_encode(['error' => 'not_logged_in']);
    exit;
}

$participant_id = $_SESSION['participant_id'];

// Récupère l’animateur du participant
$stmt = $conn->prepare("SELECT animateur_id FROM participants WHERE id = ?");
$stmt->bind_param("i", $participant_id);
$stmt->execute();
$stmt->bind_result($animateur_id);
$stmt->fetch();
$stmt->close();

if (empty($animateur_id)) {
    echo json_encode(['error' => 'no_animateur']);
    exit;
}

// On récupère la dernière session de cet animateur
$sql = "
    SELECT qs.question_actuelle, q.question, c.nom AS categorie
    FROM quiz_sessions qs
    JOIN question_quiz q ON qs.question_actuelle = q.id
    JOIN categorie_quiz c ON q.categorie_id = c.id
    WHERE qs.animateur = ?
    AND qs.termine = 0
    AND qs.question_actuelle IS NOT NULL
    ORDER BY qs.date_debut DESC
    LIMIT 1
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $animateur_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $question_id = $row['question_actuelle'];

    // Appliquer htmlspecialchars() à la question pour gérer les caractères spéciaux
    $question = $row['question'];
    $question = html_entity_decode($question, ENT_QUOTES, 'UTF-8');
    $question = stripslashes($question);

    // Récupérer les réponses associées à la question
    $rep_query = $conn->prepare("SELECT id, reponse FROM reponse_quiz WHERE question_id = ?");
    $rep_query->bind_param("i", $question_id);
    $rep_query->execute();
    $rep_result = $rep_query->get_result();

    $reponses = [];
    while ($rep = $rep_result->fetch_assoc()) {
        // Décoder les entités HTML et enlever les backslashes
        $texte = html_entity_decode($rep['reponse'], ENT_QUOTES, 'UTF-8');
        $texte = stripslashes($texte);

        $reponses[] = [
            'id' => $rep['id'],
            'reponse' => $texte
        ];
    }

    // Renvoyer la question et les réponses en JSON
    echo json_encode([
        'question_id' => $question_id,
        'question' => $question,  // Question encodée avec htmlspecialchars()
        'categorie' => $row['categorie'],
        'reponses' => $reponses
    ]);
} else {
    echo json_encode(null);
}
