<?php
// lancer_question.php
require_once '../config/db.php';
session_start();

// 🧩 Vérifie que l'animateur est bien connecté
if (!isset($_SESSION['animateur_id'])) {
    header('Location: animateur-connect');
    exit;
}

$animateur_id = (int) $_SESSION['animateur_id'];
$question_id  = isset($_POST['question_id']) ? (int) $_POST['question_id'] : 0;

if ($question_id <= 0) {
    die("ID de question invalide.");
}

/* ---------------------------------------------------------------------------
   ÉTAPE 1 : Récupère la session active (non terminée) de cet animateur
--------------------------------------------------------------------------- */
$stmt = $conn->prepare("
    SELECT id, questions_lancees 
    FROM quiz_sessions 
    WHERE animateur = ? 
      AND termine = 0
    ORDER BY id DESC 
    LIMIT 1
");
$stmt->bind_param("i", $animateur_id);
$stmt->execute();
$stmt->bind_result($session_id, $questions_lancees);
$stmt->fetch();
$stmt->close();

/* ---------------------------------------------------------------------------
   ÉTAPE 2 : Si aucune session active → on crée une nouvelle
--------------------------------------------------------------------------- */
if (empty($session_id)) {

    // 🔹 Récupère la catégorie de la question qu'on veut lancer
    $cat_stmt = $conn->prepare("SELECT categorie_id FROM question_quiz WHERE id = ?");
    $cat_stmt->bind_param("i", $question_id);
    $cat_stmt->execute();
    $cat_stmt->bind_result($categorie_id);
    $cat_stmt->fetch();
    $cat_stmt->close();

    // 🔹 Crée une nouvelle session avec cette catégorie
    // On met directement questions_lancees = 1 (première question lancée)
    $insert = $conn->prepare("
        INSERT INTO quiz_sessions (animateur, categorie_id, date_debut, termine, questions_lancees) 
        VALUES (?, ?, NOW(), 0, 1)
    ");
    $insert->bind_param("ii", $animateur_id, $categorie_id);
    $insert->execute();
    $session_id = $insert->insert_id;
    $insert->close();

    // 🔹 Met à jour la question actuelle
    $update = $conn->prepare("
        UPDATE quiz_sessions 
        SET question_actuelle = ? 
        WHERE id = ?
    ");
    $update->bind_param("ii", $question_id, $session_id);
    $update->execute();
    $update->close();
} else {
    /* -----------------------------------------------------------------------
       ÉTAPE 3 : Si une session existe déjà → on incrémente et on met à jour
    ----------------------------------------------------------------------- */

    // 🔹 Réinitialise le statut "a_repondu" de tous les participants liés
    $reset_status = $conn->prepare("
        UPDATE participants 
        SET a_repondu = 0 
        WHERE animateur_id = ?
    ");
    $reset_status->bind_param("i", $animateur_id);
    $reset_status->execute();
    $reset_status->close();

    // 🔹 Met à jour la question actuelle + incrémente le compteur
    $update = $conn->prepare("
        UPDATE quiz_sessions 
        SET question_actuelle = ?, 
            questions_lancees = questions_lancees + 1 
        WHERE id = ?
    ");
    $update->bind_param("ii", $question_id, $session_id);
    $update->execute();

    // 🔹 Vérification facultative pour debug
    if ($update->affected_rows === 0) {
        error_log("⚠️ Aucun enregistrement mis à jour pour session_id=$session_id");
    }

    $update->close();
}

/* ---------------------------------------------------------------------------
   ÉTAPE 4 : Stocke l’ID de la question dans la session PHP
--------------------------------------------------------------------------- */
$_SESSION['question_lancee'] = $question_id;

/* ---------------------------------------------------------------------------
   ÉTAPE 5 : Redirige l’animateur vers son tableau de bord
--------------------------------------------------------------------------- */
header("Location: animateur?success=1");
exit;
