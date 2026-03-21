<?php
require_once '../inclusion/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $motdepasse = $_POST['motdepasse'];

    $stmt = $pdo->prepare("SELECT * FROM formateurs WHERE email = ?");
    $stmt->execute([$email]);
    $formateur = $stmt->fetch();

    if ($formateur && password_verify($motdepasse, $formateur['motdepasse'])) {
        // Connexion réussie
        $_SESSION['formateur_id'] = $formateur['id'];
        $_SESSION['formateur'] = $formateur;
        header('Location: https://monespacevolontaire.sternaafrica.org/admin/');
        exit;
    } else {
        echo "Identifiants incorrects.";
        exit;
    }
}
