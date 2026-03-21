<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once '../inclusion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    $email = trim($_POST['email']);

    // Vérifie si le mail existe dans les formateurs
    $stmt = $pdo->prepare("SELECT * FROM formateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Génère un token unique
        $token = bin2hex(random_bytes(32));
        $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Enregistre dans la table reset_tokens
        $stmt = $pdo->prepare("INSERT INTO reset_tokens (user_email, token, expires_at) VALUES (?, ?, ?)");
        $stmt->execute([$email, $token, $expires_at]);

        // Prépare le lien de réinitialisation
        $resetLink = "https://monespacevolontaire.sternaafrica.org/admin/reinitialiser.php?token=$token";

        // Envoi de l'email (simple version)
        $to = $email;
        $subject = "Réinitialisation de votre mot de passe";
        $message = "Bonjour,\n\nCliquez sur ce lien pour réinitialiser votre mot de passe :\n$resetLink\n\nCe lien expire dans 1 heure.";
        $headers = "From: no-reply@sternaafrica.org";

        mail($to, $subject, $message, $headers);
    }

    // Redirection (ne pas révéler si l'email existe ou pas)
    header('Location: https://monespacevolontaire.sternaafrica.org/admin/login.php?message=Un lien vous a été envoyé si l’adresse est valide');
    exit;
}
?>
