<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

if (!isset($_GET['id'])) {
    header("Location: admin_rapports.php");
    exit();
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM rapports WHERE id = $id";
$result = $conn->query($sql);
if (!$result || $result->num_rows == 0) {
    header("Location: admin_rapports.php?message=Rapport introuvable");
    exit();
}
$rapport = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Rapport</title>
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 mb-8" style="max-width: 600px;">
        <h2 class="comic-neue-bold mb-4">Modifier le rapport</h2>
        <form action="traitement_update_rapport.php" method="POST" enctype="multipart/form-data" class="mb-8">
            <input type="hidden" name="id" value="<?= $rapport['id'] ?>">
            
            <div class="mb-3">
                <label class="form-label fw-bold">Type de document *</label>
                <select name="type_document" id="type_document" class="form-control" required onchange="toggleTrimestre()">
                    <option value="bulletin" <?= ($rapport['type_document'] ?? 'bulletin') === 'bulletin' ? 'selected' : '' ?>>Bulletin Trimestriel</option>
                    <option value="rapport_annuel" <?= ($rapport['type_document'] ?? '') === 'rapport_annuel' ? 'selected' : '' ?>>Rapport Annuel</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Année *</label>
                <select name="annee" class="form-control" required>
                    <?php 
                    $current_year = date("Y");
                    $saved_year = isset($rapport['annee']) ? $rapport['annee'] : $current_year;
                    for($i = $current_year; $i >= 2020; $i--) {
                        $selected = ($i == $saved_year) ? 'selected' : '';
                        echo "<option value=\"$i\" $selected>$i</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3" id="trimestre_div">
                <label class="form-label fw-bold">Trimestre *</label>
                <select name="trimestre" id="trimestre" class="form-control">
                    <?php 
                    $saved_tri = isset($rapport['trimestre']) ? $rapport['trimestre'] : '';
                    foreach(['T1'=>'Trimestre 1 (T1)', 'T2'=>'Trimestre 2 (T2)', 'T3'=>'Trimestre 3 (T3)', 'T4'=>'Trimestre 4 (T4)'] as $val => $label) {
                        $selected = ($val == $saved_tri) ? 'selected' : '';
                        echo "<option value=\"$val\" $selected>$label</option>";
                    }
                    ?>
                </select>
            </div>
            
            <script>
                function toggleTrimestre() {
                    var type = document.getElementById("type_document").value;
                    var trimestreDiv = document.getElementById("trimestre_div");
                    var trimestreSelect = document.getElementById("trimestre");
                    if (type === "rapport_annuel") {
                        trimestreDiv.style.display = "none";
                        trimestreSelect.required = false;
                    } else {
                        trimestreDiv.style.display = "block";
                        trimestreSelect.required = true;
                    }
                }
                // Run on load to set initial state
                window.onload = toggleTrimestre;
            </script>
            
            <div class="mb-4 p-3 border rounded bg-light">
                <label class="form-label fw-bold">Le document (PDF)</label>
                <div class="mb-2">Actuel : <a href="<?= htmlspecialchars($rapport['pdf_link']) ?>" target="_blank">Voir</a></div>
                <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                <small class="text-muted">Laissez vide pour conserver le document actuel.</small>
            </div>
            
            <div class="mb-4 p-3 border rounded bg-light">
                <label class="form-label fw-bold">Image de couverture</label>
                <?php if(!empty($rapport['cover_image'])): ?>
                    <div class="mb-2">
                        <img src="<?= htmlspecialchars($rapport['cover_image']) ?>" style="height:60px;">
                    </div>
                <?php endif; ?>
                <input type="file" name="cover_file" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                <small class="text-muted">Laissez vide pour conserver l'image actuelle.</small>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="admin_rapports.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Mettre à jour le rapport</button>
            </div>
        </form>
        <br>
    </div>
</body>
</html>
