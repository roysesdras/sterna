<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 9) {
    die("Accès refusé.");
}

require_once 'inclusion/db.php';

if (!empty($_POST['nom_categorie'])) {
    $nom = trim($_POST['nom_categorie']);

    // Prépare l'insertion
    $stmt = $pdo->prepare("INSERT INTO categories (nom, date_creation) VALUES (?, NOW())");
    $stmt->execute([$nom]);

    $_SESSION['success_message'] = "Catégorie ajoutée avec succès.";
} else {
    $_SESSION['error_message'] = "Le nom de la catégorie est obligatoire.";
}

header("Location: /");
exit;
