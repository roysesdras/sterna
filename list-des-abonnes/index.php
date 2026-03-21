<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// --- SUPPRESSION (Ton code existant) ---
if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM abonnes WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: admin_abonnes.php?msg=deleted"); // Redirection propre
    exit();
}

// --- RÉCUPÉRATION DES EMAILS POUR L'ENVOI GROUPÉ ---
$result_emails = $conn->query("SELECT email FROM abonnes WHERE confirmé = 1");
$emails_list = [];
while ($row = $result_emails->fetch_assoc()) {
    $emails_list[] = $row['email'];
}
$all_emails_str = implode(',', $emails_list);

// Utilisation de BCC pour protéger la vie privée des abonnés
$mailto_link = "mailto:sternaafrica@gmail.com?bcc=" . $all_emails_str;
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Gestion Newsletter - Sterna Africa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body class="bg-light">

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>👥 Abonnés Newsletter</h2>
            <div>
                <?php if (!empty($emails_list)): ?>
                    <button onclick="copyEmails()" class="btn btn-outline-secondary me-2">
                        <i class="fas fa-copy"></i> Copier la liste
                    </button>
                    <a href="<?php echo $mailto_link; ?>" class="btn btn-warning text-dark fw-bold">
                        <i class="fas fa-paper-plane"></i> Envoyer une Newsletter
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
            <div class="alert alert-success">Abonné supprimé avec succès.</div>
        <?php endif; ?>

        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Email</th>
                            <th>Inscription</th>
                            <th class="text-center">Statut</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $conn->query("SELECT * FROM abonnes ORDER BY date_inscription DESC");
                        if ($result->num_rows > 0):
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td>#<?php echo $row['id']; ?></td>
                                    <td class="fw-bold"><?php echo htmlspecialchars($row['email']); ?></td>
                                    <td><?php echo date('d/m/Y H:i', strtotime($row['date_inscription'])); ?></td>
                                    <td class="text-center">
                                        <span class="badge <?php echo $row['confirmé'] ? 'bg-success' : 'bg-secondary'; ?>">
                                            <?php echo $row['confirmé'] ? 'Actif' : 'En attente'; ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <a href="mailto:<?php echo $row['email']; ?>" class="btn btn-outline-primary btn-sm">Contacter</a>
                                        <a href="?action=delete&id=<?php echo $row['id']; ?>"
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="return confirm('Supprimer cet abonné ?');">Supprimer</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center p-4">Aucun abonné pour le moment.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Fonction pour copier les emails dans le presse-papier
        function copyEmails() {
            const emails = "<?php echo $all_emails_str; ?>";
            navigator.clipboard.writeText(emails).then(() => {
                alert("Liste des e-mails copiée ! Vous pouvez les coller dans le champ 'BCC' de Gmail.");
            });
        }
    </script>

</body>

</html>