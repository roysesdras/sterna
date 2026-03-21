<?php
session_start();

// Vérifie si l'utilisateur est un administrateur
if (!isset($_SESSION['admin'])) {
    header('Location: ./admin_login.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../config/db.php'); 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sécuriser l'ID en le convertissant en entier

    // Utilisation d'une requête préparée pour éviter les injections SQL
    $stmt = $conn->prepare("DELETE FROM missions WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Redirection avec message de confirmation
        header('Location: ./admin_dashboard.php?message=Mission%20supprim%C3%A9e%20avec%20succ%C3%A8s');
        exit();
    } else {
        // Gestion de l'erreur si la suppression échoue
        echo "Erreur lors de la suppression de la mission : " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Si l'ID de la mission n'est pas spécifié dans la requête GET
    echo "ID de mission non spécifié.";
}
?>
