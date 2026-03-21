<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once './inclusion/config.php';

$login_url = $client->createAuthUrl();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Espace Volontaire</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 flex items-center justify-center min-h-screen">

    <div class="bg-gray-800 p-8 rounded-2xl shadow-lg w-full max-w-md text-center">
        <h1 class="text-2xl font-semibold text-white mb-6">Connexion à l’Espace Volontaire</h1>

        <p class="text-gray-400 mb-6">Connecte-toi avec ton compte Google pour accéder à ton espace personnel.</p>

        <a href="<?= htmlspecialchars($login_url) ?>"
            class="inline-flex items-center justify-center w-full px-4 py-2 bg-white text-gray-800 font-medium rounded-lg shadow hover:bg-gray-100 transition duration-200">
            <svg class="w-5 h-5 mr-2" viewBox="0 0 488 512" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path d="M488 261.8C488 403.3 391.4 512 248 512 110.9 512 8 409.1 8 272S110.9 32 248 32c66.8 0 123.1 24.5 167.3 64.9l-67.7 65.3C323.8 133.2 288.7 120 248 120c-82.7 0-150 68.3-150 152s67.3 152 150 152c70.6 0 124.5-48.2 135.5-112H248v-96h240v48.8z" />
            </svg>
            Se connecter avec Google
        </a>
    </div>

</body>

</html>