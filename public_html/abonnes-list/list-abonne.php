<?php
// Connexion à la base de données
$servername = "localhost"; 
$username = "u694220522_sterna_africa"; 
$password = "@sterna_Africa225"; 
$dbname = "u694220522_africa_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Échec de la connexion à la base de données.");
}

// Supprimer un abonné
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM abonnes WHERE id = ?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Abonné supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression de l'abonné.</div>";
    }
    $stmt->close();
}

// Récupérer tous les abonnés
$result = $conn->query("SELECT email FROM abonnes");

// Vérifiez si la requête a réussi
if (!$result) {
    die("Erreur lors de la récupération des abonnés: " . $conn->error);
}

// Préparer les e-mails pour le lien mailto
$emails = [];
while ($row = $result->fetch_assoc()) {
    $emails[] = $row['email'];
}

// Créer un lien mailto si des e-mails existent
$mailto_link = '';
if (!empty($emails)) {
    $to = "sternaafrica@gmail.com"; // Votre adresse e-mail pour envoyer depuis votre client
    $cc = implode(',', $emails); // Liste des e-mails des abonnés
    $mailto_link = "mailto:$to?cc=$cc"; // Lien mailto avec CC rempli
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des abonnés</title>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

</head>
<body style="background-color: #ebebeb; color: #333;">
<div class="container mt-5">
    <h2>Liste des abonnés à la newsletter</h2>

    <form method="POST" action="" class="mb-3">
        <!-- Lien mailto pour ouvrir le client de messagerie avec toutes les adresses en CC -->
        <?php if ($mailto_link): ?>
            <a href="<?php echo htmlspecialchars($mailto_link); ?>" class="btn btn-warning">Ouvrir le client mail pour envoyer à tous</a>
        <?php else: ?>
            <button type="button" class="btn btn-secondary" disabled>Aucun abonné à contacter</button>
        <?php endif; ?>
    </form>

    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Date d'inscription</th>
                <th>Confirmé</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Récupération complète des abonnés
            $result = $conn->query("SELECT * FROM abonnes");
            if ($result->num_rows > 0): 
                while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td>
                            <?php 
                            // Formatage de la date d'inscription
                            $dateInscription = date('d-m-Y \à H:i', strtotime($row['date_inscription']));
                            echo htmlspecialchars($dateInscription); 
                            ?>
                        </td>
                        <td><?php echo $row['confirmé'] ? 'Oui' : 'Non'; ?></td>
                        <td>
                            <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="btn btn-primary btn-sm">Envoyer mail</a>
                            <a href="?action=delete&id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet abonné ?');">Supprimer</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">Aucun abonné trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


<?php  require_once('../config/footer_2.php'); ?>
</body>
</html>

<?php
$conn->close();
?>
