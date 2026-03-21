<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start();
require_once './inclusion/config.php';
require_once './inclusion/db.php';

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        $oauth = new Google_Service_Oauth2($client);
        $userData = $oauth->userinfo->get();

        $google_id = $userData->id;
        $email = $userData->email;

        // Vérifier si l'utilisateur existe
        $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
        $stmt->execute([$google_id]);
        $user = $stmt->fetch();

        if (!$user) {
            // Nouvel utilisateur : insertion avec profil incomplet
            $stmt = $pdo->prepare("INSERT INTO users (google_id, email, profile_completed) VALUES (?, ?, 0)");
            $stmt->execute([$google_id, $email]);
        }

        $_SESSION['google_id'] = $google_id;

        // Vérifier si le profil est complété
        $stmt = $pdo->prepare("SELECT profile_completed FROM users WHERE google_id = ?");
        $stmt->execute([$google_id]);
        $user = $stmt->fetch();

        if ($user && $user['profile_completed']) {
            header("Location: /");
            exit;
        } else {
            header("Location: complet-profile");
            exit;
        }
    }
}

// En cas d'erreur
header("Location: connect");
exit;
?>
