<?php
header('Content-Type: application/json');
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

    if (!$email) {
        echo json_encode(['success' => false, 'message' => "Adresse e-mail invalide."]);
        exit;
    }

    try {
        // Migration: créer la table si elle n'existe pas
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS newsletter_subscribers (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) UNIQUE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (?)");
        $stmt->execute([$email]);

        echo json_encode(['success' => true, 'message' => "Merci pour ton inscription !"]);
    } catch (PDOException $e) {
        // Code 23000 = contrainte d'unicité (email déjà existant)
        if ($e->getCode() == 23000) {
            echo json_encode(['success' => true, 'message' => "Tu es déjà inscrit à la newsletter !"]);
        } else {
            echo json_encode(['success' => false, 'message' => "Erreur lors de l'inscription."]);
        }
    }
} else {
    echo json_encode(['success' => false, 'message' => "Requête invalide."]);
}
