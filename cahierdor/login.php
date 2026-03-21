<?php
session_start();
require_once 'vendor/autoload.php';
require_once 'includes/db.php'; // ta connexion PDO

// Config Google
$clientID = '102756207325-4i9to4lqqg94fh99dt6gusbag1gfu26q.apps.googleusercontent.com';
$clientSecret = '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';
$redirectUri = 'https://cahierdor.sternaafrica.org/login.php';

// Initialiser client Google
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);

        // Récupérer les infos utilisateur
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        $google_id = $google_account_info->id;
        $name = $google_account_info->name;
        $email = $google_account_info->email;
        $avatar = $google_account_info->picture;

        // Vérifier si utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ?");
        $stmt->execute([$google_id]);
        $user = $stmt->fetch();

        if (!$user) {
            // Créer nouvel utilisateur
            $stmt = $pdo->prepare("INSERT INTO users (google_id, name, email, avatar) VALUES (?, ?, ?, ?)");
            $stmt->execute([$google_id, $name, $email, $avatar]);
            $user_id = $pdo->lastInsertId();
        } else {
            $user_id = $user['id'];
        }

        // Créer session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['name'] = $name;
        $_SESSION['avatar'] = $avatar;

        header('Location: raconte-ta-journee');
        exit();
    } else {
        echo "Erreur de connexion à Google.";
    }
} else {
    // Pas encore connecté → redirection Google
    $authUrl = $client->createAuthUrl();
    header('Location: ' . $authUrl);
    exit();
}
