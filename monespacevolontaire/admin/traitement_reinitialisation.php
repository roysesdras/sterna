<?php
require_once '../inclusion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['token'], $_POST['password'])) {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Vérifie le token
    $stmt = $pdo->prepare("SELECT * FROM reset_tokens WHERE token = ? AND used = 0 AND expires_at > NOW()");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if ($reset) {
        $email = $reset['user_email'];

        // Met à jour le mot de passe du formateur
        $stmt = $pdo->prepare("UPDATE formateurs SET motdepasse = ? WHERE email = ?");
        $stmt->execute([$password, $email]);

        // Marque le token comme utilisé
        $stmt = $pdo->prepare("UPDATE reset_tokens SET used = 1 WHERE token = ?");
        $stmt->execute([$token]);

        header("Location: login.php?message=Mot de passe mis à jour !");
        exit;
    } else {
        die("Lien invalide ou expiré.");
    }
}
?>
