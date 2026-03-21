<?php
require_once '../inclusion/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $email = trim($_POST['email']);
    $motdepasse = $_POST['motdepasse'];

    // Gérer l'upload de l'avatar
    $avatar = '';
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {
        $uploadDir = 'uploads/';
        $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $avatar = uniqid('avatar_') . '.' . $ext;
        move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $avatar);
    }

    // Vérifier si l'utilisateur existe déjà
    $stmt = $pdo->prepare("SELECT id FROM formateurs WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        echo "Un compte avec cet email existe déjà.";
        exit;
    }

    // Insérer le formateur
    $hash = password_hash($motdepasse, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO formateurs (nom, prenom, email, motdepasse, avatar) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$nom, $prenom, $email, $hash, $avatar]);

    header('Location: login.php');
    exit;
}
