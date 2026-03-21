<?php
session_start();

require_once('../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actualite_id = intval($_POST['actualite_id']);
    $user_name = htmlspecialchars($_POST['user_name']);
    $comment = htmlspecialchars($_POST['comment']);

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
