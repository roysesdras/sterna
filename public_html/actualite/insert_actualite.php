<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../admin_login.php');
    exit();
}

if (isset($_POST['submit'])) {
    $conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Filtrer les entrées utilisateur pour éviter les attaques XSS
    $title = htmlspecialchars($_POST['title']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $image = $_FILES['image']['name'];
    $target = "../images/" . basename($image);

    // Vérifier si le fichier a été téléchargé avec succès
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Préparer la requête SQL
        $stmt = $conn->prepare("INSERT INTO actualites (title, start_date, end_date, image) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $title, $start_date, $end_date, $image);

        // Exécuter la requête SQL
        if ($stmt->execute()) {
            header('Location: ../admin_dashboard.php?message=Actualité%20ajoutée%20avec%20succès');
            exit(); // Assurez-vous de terminer le script après une redirection
        } else {
            echo "Erreur lors de l'ajout de l'actualité: " . $stmt->error;
        }
    } else {
        echo "Erreur lors du téléchargement de l'image.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Nouvelle Actualité</title>
</head>
<body>
    <h1>Ajouter une Nouvelle Actualité</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="title">Titre :</label><br>
        <input type="text" id="title" name="title" required><br><br>

        <label for="start_date">Date de début :</label><br>
        <input type="date" id="start_date" name="start_date" required><br><br>

        <label for="end_date">Date de fin :</label><br>
        <input type="date" id="end_date" name="end_date" required><br><br>

        <label for="image">Image :</label><br>
        <input type="file" id="image" name="image" required><br><br>

        <input type="submit" name="submit" value="Ajouter l'actualité">
    </form>
</body>
</html>
