<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un projet</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="bg-dark text-light">
  <div class="container mt-5">
    <h2>Ajouter un projet</h2>
    <form action="traitement_insert_projet.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom du Projet</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
      </div>
      <div class="mb-3">
        <label for="slug" class="form-label">Slug (identifiant URL, ex: educmoi, camp-ecsi)</label>
        <input type="text" class="form-control" id="slug" name="slug" required>
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Description du projet</label>
        <textarea class="form-control" id="description" name="description" rows="5"></textarea>
      </div>
      <div class="mb-3">
        <label for="image_main" class="form-label">Image Principale (Affichée sur les cartes)</label>
        <input type="file" class="form-control" id="image_main" name="image_main" accept="image/*">
      </div>
      <div class="mb-3">
        <label for="image_2" class="form-label">Image Secondaire 1 (Galerie optionnelle)</label>
        <input type="file" class="form-control" id="image_2" name="image_2" accept="image/*">
      </div>
      <div class="mb-3">
        <label for="image_3" class="form-label">Image Secondaire 2 (Galerie optionnelle)</label>
        <input type="file" class="form-control" id="image_3" name="image_3" accept="image/*">
      </div>
      <button type="submit" class="btn btn-success">Enregistrer le projet</button>
      <a href="admin_projets.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
  
  <script>
    document.addEventListener("DOMContentLoaded", function() {
        const descriptionField = document.getElementById("description");
        if (descriptionField) {
            descriptionField.addEventListener("input", function() {
                this.style.height = "auto";
                this.style.height = (this.scrollHeight) + "px";
            });
            // Ajustement initial
            descriptionField.style.height = "auto";
            descriptionField.style.height = (descriptionField.scrollHeight) + "px";
        }
    });
  </script>
</body>
</html>
