-<?php
require_once '../inclusion/db.php'; // Connexion à la base de données

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $volontaire_id = $_POST['volontaire_id'] ?? null;
    $note = $_POST['note'] ?? null;
    $commentaire = $_POST['commentaire'] ?? '';

    if ($volontaire_id !== null && is_numeric($note)) {
        $volontaire_id = (int)$volontaire_id;
        $note = (float)$note;

        // Vérifier si une note existe déjà pour ce volontaire (par exemple dans une table notes_modules)
        $stmt_check = $pdo->prepare("SELECT id FROM notes_modules WHERE volontaire_id = ?");
        $stmt_check->execute([$volontaire_id]);

        if ($stmt_check->fetch()) {
            // Mise à jour si déjà existant
            $stmt = $pdo->prepare("UPDATE notes_modules SET note = ?, commentaire = ?, date_modification = NOW() WHERE volontaire_id = ?");
            $stmt->execute([$note, $commentaire, $volontaire_id]);
        } else {
            // Insertion sinon
            $stmt = $pdo->prepare("INSERT INTO notes_modules (volontaire_id, note, commentaire, date_creation) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$volontaire_id, $note, $commentaire]);
        }

        // Redirection vers la page précédente
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    } else {
        echo "Erreur : données invalides.";
    }
} else {
    echo "Méthode non autorisée.";
}
