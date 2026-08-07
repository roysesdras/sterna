<?php
session_start();

// Désactive toutes les variables de session
$_SESSION = [];

// Supprime le cookie de session s'il existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Détruit la session
session_destroy();

// Optionnel : détruire aussi d'autres cookies personnalisés
if (isset($_COOKIE['remember_me'])) {
    setcookie('remember_me', '', time() - 3600, '/');
}

// Redirection après déconnexion
header("Location: login.php"); // tu peux changer vers accueil, index, etc.
exit;
