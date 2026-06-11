<?php
require_once 'includes/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Adresse e-mail invalide.']);
        exit();
    }

    try {
        // S'assurer que la table existe
        $pdo->exec("CREATE TABLE IF NOT EXISTS subscribers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            email VARCHAR(255) UNIQUE NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");

        // Vérifier si déjà inscrit
        $stmt = $pdo->prepare("SELECT id FROM subscribers WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->fetch()) {
            echo json_encode(['success' => false, 'message' => 'Vous êtes déjà abonné ! 😊']);
            exit();
        }

        // Insérer
        $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (?)");
        $result = $stmt->execute([$email]);

        if ($result) {
            // Envoyer un email de confirmation de bienvenue
            $subject = "Bienvenue sur le Livre d'Or de Sterna Africa 🌟";
            $message = "Bonjour,\n\nVous êtes bien abonné aux notifications du Livre d'Or de Sterna Africa.\n\nVous recevrez un e-mail à chaque fois qu'un nouveau récit de chantier est publié !\n\nÀ bientôt,\nL'équipe Sterna Africa";
            
            $headers = "From: Sterna Africa <sternaafrica@gmail.com>\r\n";
            $headers .= "Reply-To: sternaafrica@gmail.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            @mail($email, $subject, $message, $headers);

            echo json_encode(['success' => true, 'message' => 'Inscription réussie ! Vous recevrez un e-mail de confirmation. 🎉']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Une erreur est survenue lors de l\'inscription.']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur de base de données : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}
exit();
