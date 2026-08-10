<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

$sql_create = "CREATE TABLE IF NOT EXISTS rapports (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(255) NOT NULL,
    cover_image VARCHAR(255) DEFAULT NULL,
    pdf_link VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_create);

$sql = "SELECT * FROM rapports ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rapports</title>
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 comic-neue-bold">Tableau de bord Rapports et Documents</h2>
        </div>
        
        <?php if (isset($_GET['message'])) {
            echo "<div class='alert alert-info comic-neue-regular'>{$_GET['message']}</div>";
        } ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Image de couverture</th>
                        <th>Lien PDF / Doc</th>
                        <th>Date d'ajout</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php while ($rapport = $result->fetch_assoc()): ?>
                            <tr>
                                <td class="text-center"><?= $rapport['id'] ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($rapport['titre']) ?></td>
                                <td class="text-center">
                                    <?php if(!empty($rapport['cover_image'])): ?>
                                        <img src="<?= htmlspecialchars($rapport['cover_image']) ?>" style="width: 80px; height: 60px; object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        <span class="text-muted">Par défaut</span>
                                    <?php endif; ?>
                                </td>
                                <td><a href="<?= htmlspecialchars($rapport['pdf_link']) ?>" target="_blank">Voir le document</a></td>
                                <td class="text-center"><?= date('d/m/Y', strtotime($rapport['created_at'])) ?></td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a href="admin_edit_rapport.php?id=<?= $rapport['id'] ?>" class="btn btn-warning btn-sm" title="Modifier"><i class="bi bi-pencil-square"></i></a>
                                        <a href="admin_delete_rapport.php?id=<?= $rapport['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce rapport ?');" title="Supprimer"><i class="bi bi-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr><td colspan='6' class='text-center p-4'>Aucun rapport trouvé.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="d-flex justify-content-between mb-5">
            <a href="../admin/admin_dashboard.php" class="btn btn-secondary btn-sm">← Retour Dashboard</a>
            <a href="admin_add_rapport.php" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Nouveau Rapport</a>
            <a href="../admin/admin_logout.php" class="btn btn-danger btn-sm">Déconnexion</a>
        </div>
    </div>
</body>
</html>
