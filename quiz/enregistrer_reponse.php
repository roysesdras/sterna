<?php
/**
 * enregistrer_reponse.php
 * Enregistre les choix du participant et calcule les points (10 pts par question)
 */

ini_set('display_errors', 0); // Désactivé pour la production
error_reporting(E_ALL);

require_once '../config/db.php';
session_start();
 
// 1. Récupération des données de session et POST
$participant_id = $_SESSION['participant_id'] ?? null;
$partie_id = $_SESSION['partie_id'] ?? 0;
$question_id = (int) ($_POST['question_id'] ?? 0);
$reponses = $_POST['reponses'] ?? []; // Tableau des IDs de réponses cochées

// 2. Vérifications de base
if (!$participant_id || !$question_id || !$partie_id || empty($reponses)) {
    exit("<div class='text-orange-400'>⚠️ Données incomplètes ou aucune réponse choisie.</div>");
}

try {
    // 3. Vérifier si la partie est déjà terminée
    $stmt = $conn->prepare("SELECT termine FROM parties_quiz WHERE id = ?");
    $stmt->bind_param("i", $partie_id);
    $stmt->execute();
    $stmt->bind_result($termine);
    $stmt->fetch();
    $stmt->close();

    if ($termine == 1) {
        exit("<div class='text-red-400'>⚠️ Cette partie est déjà terminée !</div>");
    }

    // 4. Vérifier si le participant a déjà répondu à cette question
    $stmt = $conn->prepare("
        SELECT COUNT(*) 
        FROM reponses_participants_quiz 
        WHERE participant_id = ? AND question_id = ? AND partie_id = ?
    ");
    $stmt->bind_param("iii", $participant_id, $question_id, $partie_id);
    $stmt->execute();
    $stmt->bind_result($deja_repondu);
    $stmt->fetch();
    $stmt->close();

    if ($deja_repondu > 0) {
        exit("<div class='text-blue-400'>ℹ️ Vous avez déjà validé cette question.</div>");
    }
    
    // 5. Analyse de la justesse et Insertion des réponses
    $insert = $conn->prepare("
        INSERT INTO reponses_participants_quiz 
        (participant_id, question_id, reponse_id, partie_id, date_reponse)
        VALUES (?, ?, ?, ?, NOW())
    ");

    $nb_correctes_choisies = 0;
    $nb_fausses_choisies = 0;

    foreach ($reponses as $r_id) {
        $r_id = (int) $r_id;

        // Vérifier si cette option précise est correcte
        $check = $conn->prepare("SELECT correcte FROM reponse_quiz WHERE id = ?");
        $check->bind_param("i", $r_id);
        $check->execute();
        $check->bind_result($est_correcte);
        $check->fetch();
        $check->close();

        if ($est_correcte == 1) {
            $nb_correctes_choisies++;
        } else {
            $nb_fausses_choisies++;
        }

        // Enregistrement du choix en base
        $insert->bind_param("iiii", $participant_id, $question_id, $r_id, $partie_id);
        $insert->execute();
    }
    $insert->close();

    // 6. Attribution des points (10 pts si au moins une juste ET aucune fausse)
    $points_a_ajouter = ($nb_correctes_choisies > 0 && $nb_fausses_choisies === 0) ? 10 : 0;

    // 7. Mise à jour du score cumulé dans scores_participants
    $stmt = $conn->prepare("SELECT id FROM scores_participants WHERE participant_id = ? AND partie_id = ?");
    $stmt->bind_param("ii", $participant_id, $partie_id);
    $stmt->execute();
    $score_exist = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if ($score_exist) {
        $update = $conn->prepare("UPDATE scores_participants SET score_total = score_total + ? WHERE participant_id = ? AND partie_id = ?");
        $update->bind_param("iii", $points_a_ajouter, $participant_id, $partie_id);
        $update->execute();
        $update->close();
    } else {
        $insert_score = $conn->prepare("INSERT INTO scores_participants (participant_id, partie_id, score_total) VALUES (?, ?, ?)");
        $insert_score->bind_param("iii", $participant_id, $partie_id, $points_a_ajouter);
        $insert_score->execute();
        $insert_score->close();
    }

    // 8. Marquer le participant comme ayant répondu pour l'interface animateur
    $update_p = $conn->prepare("UPDATE participants SET a_repondu = 1 WHERE id = ?");
    $update_p->bind_param("i", $participant_id);
    $update_p->execute();
    $update_p->close();

    // 9. Feedback visuel renvoyé au JavaScript
    if ($points_a_ajouter > 0) {
        echo "<div class='text-green-400 font-bold animate-bounce'>✅ Bravo ! +$points_a_ajouter points</div>";
    } else {
        echo "<div class='text-red-400 font-bold'>❌ Dommage, ce n'est pas la bonne réponse.</div>";
    }

} catch (Exception $e) {
    echo "<div class='text-red-500'>❌ Erreur système : " . $e->getMessage() . "</div>";
}