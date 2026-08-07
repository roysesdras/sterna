<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Rapport</title>
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5" style="max-width: 600px;">
        <h2 class="comic-neue-bold mb-4">Ajouter un nouveau rapport</h2>
        <form action="traitement_insert_rapport.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label fw-bold">Type de document *</label>
                <select name="type_document" id="type_document" class="form-control" required onchange="toggleTrimestre()">
                    <option value="bulletin">Bulletin Trimestriel</option>
                    <option value="rapport_annuel">Rapport Annuel</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label fw-bold">Année *</label>
                <select name="annee" class="form-control" required>
                    <?php 
                    $current_year = date("Y");
                    for($i = $current_year; $i >= 2020; $i--) {
                        echo "<option value=\"$i\">$i</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3" id="trimestre_div">
                <label class="form-label fw-bold">Trimestre *</label>
                <select name="trimestre" id="trimestre" class="form-control">
                    <option value="T1">Trimestre 1 (T1)</option>
                    <option value="T2">Trimestre 2 (T2)</option>
                    <option value="T3">Trimestre 3 (T3)</option>
                    <option value="T4">Trimestre 4 (T4)</option>
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
                <label class="form-label fw-bold">Le document (PDF) *</label>
                <input type="file" name="pdf_file" class="form-control" accept=".pdf" required>
                <small class="text-muted">Sélectionnez le fichier PDF du rapport depuis votre ordinateur.</small>
            </div>
            
            <div class="mb-4 p-3 border rounded bg-light">
                <label class="form-label fw-bold">Image de couverture (Optionnel)</label>
                <input type="file" name="cover_file" class="form-control" accept="image/png, image/jpeg, image/jpg, image/webp">
                <small class="text-muted">Si vide, l'image par défaut de Sterna sera utilisée.</small>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="admin_rapports.php" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-success">Importer et Ajouter le rapport</button>
            </div>
        </form>
    </div>
</body>
</html>
