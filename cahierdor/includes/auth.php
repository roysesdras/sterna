<?php
session_start();

// Fonction pour vérifier si l'utilisateur est connecté
function is_logged_in()
{
    return isset($_SESSION['user_id']);
}

// Fonction pour rediriger si l'utilisateur n'est pas connecté
function require_login()
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}

// Fonction pour récupérer l’ID de l’utilisateur connecté
function current_user_id()
{
    return $_SESSION['user_id'] ?? null;
}

// Fonction pour savoir si l'utilisateur est admin (facultatif)
function is_admin($pdo)
{
    if (!is_logged_in()) return false;

    $stmt = $pdo->prepare("SELECT role FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();

    return $user && $user['role'] === 'admin';
}
