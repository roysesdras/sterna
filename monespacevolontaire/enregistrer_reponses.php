<?php
session_start();
require 'pdo.php'; // connexion PDO

$volontaire_id = $_SESSION['volontaire_id'] ?? null;
$module_id = $_POST['module_id'] ?? null;
$reponses = $_POST['reponses'] ?? [];

if ($volontaire_id && $module_id && !empty($reponses)) {
    $stmt = $pdo->prepare("INSERT INTO reponses (volontaire_id, module_id, question_id, reponse, date_reponse) 
                           VALUES (?, ?, ?, ?, NOW())");

    foreach ($reponses as $question_id => $texte) {
        if (trim($texte) !== '') {
            $stmt->execute([$volontaire_id, $module_id, $question_id, $texte]);
        }
    }

    header("Location: formations.php?success=1");
    exit;
} else {
    header("Location: formations.php?error=1");
    exit;
}
