<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

// Vérification de l'ID de l'actualité à supprimer
if (!isset($_GET['id'])) {
    header('Location: admin_dashboard.php?error=ID%20d%27actualit%C3%A9%20non%20fourni');
    exit();
}
$id = $_GET['id'];

// Connexion à la base de données
$conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Supprimer l'actualité de la base de données
$sql_delete = "DELETE FROM actualites WHERE id = ?";
$stmt = $conn->prepare($sql_delete);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: admin_actualites.php?message=Actualit%C3%A9%20supprim%C3%A9e%20avec%20succ%C3%A8s');
    exit();
} else {
    echo "Erreur lors de la suppression de l'actualité : " . $stmt->error;
}

// Fermeture de la connexion à la base de données
$conn->close();
?>
