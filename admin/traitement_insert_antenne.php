
<?php
// Inclure le fichier de connexion à la base de données
require_once('../config/db.php');

if (isset($_POST['nom_antenne'])) {
    $nom_antenne = htmlspecialchars($_POST['nom_antenne']);
    $stmt = $conn->prepare("INSERT INTO antennes (nom) VALUES (?)");
    $stmt->bind_param("s", $nom_antenne);
    if ($stmt->execute()) {
        header('Location: admin_dashboard.php?message=Antenne ajoutée avec succès');
        exit();
    } else {
        echo "Erreur: " . $stmt->error;
    }
}
?>