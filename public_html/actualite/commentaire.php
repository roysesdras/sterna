<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actualite_id = intval($_POST['actualite_id']);
    $user_name = htmlspecialchars($_POST['user_name']);
    $comment = htmlspecialchars($_POST['comment']);

    // Connexion à la base de données
    $conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insertion du commentaire dans la base de données
    $sql = "INSERT INTO comments (actualite_id, user_name, comment) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $actualite_id, $user_name, $comment);

    if ($stmt->execute()) {
        header("Location: actualite_detail.php?id=" . $actualite_id);
        exit();
    } else {
        echo "Erreur : " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: admin_actualites.php");
    exit();
}
?>
