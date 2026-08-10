<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ./admin_login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Gestion des actions
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'valider') {
        $conn->query("UPDATE pont_solidaire SET statut = 'valide' WHERE id = $id");
        $msg = "Récit validé avec succès.";
    } elseif ($action === 'attente') {
        $conn->query("UPDATE pont_solidaire SET statut = 'en_attente' WHERE id = $id");
        $msg = "Récit remis en attente.";
    } elseif ($action === 'supprimer') {
        $conn->query("DELETE FROM pont_solidaire WHERE id = $id");
        $msg = "Récit supprimé.";
    }
    header("Location: admin_pont_solidaire.php?msg=" . urlencode($msg));
    exit();
}

$sql = "SELECT * FROM pont_solidaire ORDER BY id DESC";
$result = $conn->query($sql);
$recits = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $recits[] = $row;
    }
}
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Pont Solidaire - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .recit-text { max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    </style>
</head>
<body>
    <div class="container-fluid mt-4">
        <h2>Gestion des Récits - Pont Solidaire</h2>
        <div class="mb-3">
            <a href="admin_dashboard.php" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Retour au tableau de bord</a>
        </div>
        
        <?php if (isset($_GET['msg'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['msg']); ?></div>
        <?php endif; ?>

        <table class="table table-striped table-bordered table-hover mt-3">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nom Complet</th>
                    <th>Trajet</th>
                    <th>Structure</th>
                    <th>Dates</th>
                    <th>Extrait Récit</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($recits) > 0): ?>
                    <?php foreach ($recits as $r): ?>
                        <tr>
                            <td><?php echo $r['id']; ?></td>
                            <td><?php echo htmlspecialchars($r['nom_complet']); ?></td>
                            <td>
                                <?php echo htmlspecialchars($r['pays_provenance']); ?> ➔ <?php echo htmlspecialchars($r['pays_reception']); ?><br>
                                <small class="text-muted"><?php echo $r['type_relation']; ?></small>
                            </td>
                            <td><?php echo htmlspecialchars($r['structure_envoi']); ?></td>
                            <td>
                                Du <?php echo date('d/m/Y', strtotime($r['date_debut'])); ?> <br>
                                Au <?php echo date('d/m/Y', strtotime($r['date_fin'])); ?>
                            </td>
                            <td class="recit-text" title="<?php echo htmlspecialchars($r['recit']); ?>">
                                <?php echo htmlspecialchars($r['recit']); ?>
                            </td>
                            <td>
                                <?php if ($r['statut'] === 'valide'): ?>
                                    <span class="badge bg-success">Validé</span>
                                <?php else: ?>
                                    <span class="badge bg-warning text-dark">En attente</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($r['statut'] !== 'valide'): ?>
                                    <a href="admin_pont_solidaire.php?action=valider&id=<?php echo $r['id']; ?>" class="btn btn-success btn-sm mb-1" title="Valider pour affichage">
                                        <i class="bi bi-check-circle"></i>
                                    </a>
                                <?php else: ?>
                                    <a href="admin_pont_solidaire.php?action=attente&id=<?php echo $r['id']; ?>" class="btn btn-warning btn-sm mb-1" title="Remettre en attente">
                                        <i class="bi bi-pause-circle"></i>
                                    </a>
                                <?php endif; ?>
                                <a href="admin_edit_pont_solidaire.php?id=<?php echo $r['id']; ?>" class="btn btn-primary btn-sm mb-1" title="Modifier">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="admin_pont_solidaire.php?action=supprimer&id=<?php echo $r['id']; ?>" onclick="return confirm('Supprimer définitivement ce récit ?');" class="btn btn-danger btn-sm mb-1" title="Supprimer">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">Aucun récit de volontaire.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
