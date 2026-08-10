<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ./admin_login.php');
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Vérification de l'ID
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: admin_pont_solidaire.php?msg=" . urlencode("ID invalide."));
    exit();
}

$id = intval($_GET['id']);
$msg = "";

// Traitement de la mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom_complet = trim($_POST['nom_complet']);
    $pays_provenance = trim($_POST['pays_provenance']);
    $pays_reception = trim($_POST['pays_reception']);
    $type_relation = trim($_POST['type_relation']);
    $structure_envoi = trim($_POST['structure_envoi']);
    $date_debut = trim($_POST['date_debut']);
    $date_fin = trim($_POST['date_fin']);
    $recit = trim($_POST['recit']);
    $statut = trim($_POST['statut']);

    // TODO: Update the record
    $stmt = $conn->prepare("UPDATE pont_solidaire SET nom_complet = ?, pays_provenance = ?, pays_reception = ?, type_relation = ?, structure_envoi = ?, date_debut = ?, date_fin = ?, recit = ?, statut = ? WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("sssssssssi", $nom_complet, $pays_provenance, $pays_reception, $type_relation, $structure_envoi, $date_debut, $date_fin, $recit, $statut, $id);
        if ($stmt->execute()) {
            header("Location: admin_pont_solidaire.php?msg=" . urlencode("Récit modifié avec succès."));
            exit();
        } else {
            $msg = "Erreur lors de la mise à jour.";
        }
    } else {
        $msg = "Erreur SQL.";
    }
}

// Récupération des données actuelles
$sql = "SELECT * FROM pont_solidaire WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    header("Location: admin_pont_solidaire.php?msg=" . urlencode("Récit introuvable."));
    exit();
}

$recit_data = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Récit</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>
    <div class="container mt-4 mb-5 max-w-3xl mx-auto">
        <h2>Modifier le récit de <?php echo htmlspecialchars($recit_data['nom_complet']); ?></h2>
        <a href="admin_pont_solidaire.php" class="btn btn-secondary btn-sm mb-4"><i class="bi bi-arrow-left"></i> Retour à la liste</a>
        
        <?php if ($msg): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>

        <form method="POST" class="border p-4 rounded bg-light">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Nom complet</label>
                    <input type="text" name="nom_complet" class="form-control" value="<?php echo htmlspecialchars($recit_data['nom_complet']); ?>" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Statut</label>
                    <select name="statut" class="form-control">
                        <option value="en_attente" <?php if($recit_data['statut'] === 'en_attente') echo 'selected'; ?>>En attente</option>
                        <option value="valide" <?php if($recit_data['statut'] === 'valide') echo 'selected'; ?>>Validé</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Type de Relation</label>
                    <select name="type_relation" class="form-control">
                        <option value="sud_nord" <?php if($recit_data['type_relation'] === 'sud_nord') echo 'selected'; ?>>Sud ➔ Nord</option>
                        <option value="nord_sud" <?php if($recit_data['type_relation'] === 'nord_sud') echo 'selected'; ?>>Nord ➔ Sud</option>
                        <option value="sud_sud" <?php if($recit_data['type_relation'] === 'sud_sud') echo 'selected'; ?>>Sud ➔ Sud</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pays de Provenance</label>
                    <input type="text" name="pays_provenance" class="form-control" value="<?php echo htmlspecialchars($recit_data['pays_provenance']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Pays de Réception</label>
                    <input type="text" name="pays_reception" class="form-control" value="<?php echo htmlspecialchars($recit_data['pays_reception']); ?>" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Structure d'envoi</label>
                    <input type="text" name="structure_envoi" class="form-control" value="<?php echo htmlspecialchars($recit_data['structure_envoi']); ?>">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date Début</label>
                    <input type="date" name="date_debut" class="form-control" value="<?php echo htmlspecialchars($recit_data['date_debut']); ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Date Fin</label>
                    <input type="date" name="date_fin" class="form-control" value="<?php echo htmlspecialchars($recit_data['date_fin']); ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Le Récit</label>
                <textarea name="recit" class="form-control" rows="8" required><?php echo htmlspecialchars($recit_data['recit']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Enregistrer les modifications</button>
        </form>
    </div>
</body>
</html>
