<?php
require_once '../inclusion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reponse_id = $_POST['reponse_id'] ?? null;
    $note = $_POST['note'] ?? null;
    $commentaire = $_POST['commentaire'] ?? '';

    if ($reponse_id !== null && is_numeric($note)) {
        $reponse_id = (int)$reponse_id;
        $note = (float)$note;

        try {
            $stmt = $pdo->prepare("UPDATE reponses_examens SET note = ?, commentaire = ? WHERE id = ?");
            $stmt->execute([$note, $commentaire, $reponse_id]);
            echo "OK"; // ✨
        } catch (Exception $e) {
            echo "Erreur BDD : " . $e->getMessage();
        }
    } else {
        echo "Données invalides.";
    }
} else {
    echo "Méthode non autorisée.";
}
