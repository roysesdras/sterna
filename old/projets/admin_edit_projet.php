<?php
session_start();
if (!isset($_SESSION["admin"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: admin_projets.php");
    exit();
}

$conn = new mysqli("db", "root", "SoftiP24", "africa_db");
if ($conn->connect_error) die("Échec de la connexion : " . $conn->connect_error);

$id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM projets WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: admin_projets.php");
    exit();
}
$projet = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier un projet</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="bg-dark text-light">
  <div class="container mt-5">
    <h2>Modifier le projet</h2>
    <form action="traitement_edit_projet.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="id" value="<?= $projet['id'] ?>">
      
      <!-- Noms et Slug -->
      <div class="mb-3">
        <label for="nom" class="form-label">Nom du Projet</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($projet['nom']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="slug" class="form-label">Slug (identifiant URL)</label>
        <input type="text" class="form-control" id="slug" name="slug" value="<?= htmlspecialchars($projet['slug']) ?>" required>
      </div>

      <!-- Description -->
      <div class="mb-3">
        <label for="description" class="form-label">Description du projet</label>
        <textarea class="form-control" id="description" name="description" rows="5"><?= htmlspecialchars($projet['description'] ?? '') ?></textarea>
      </div>

      <!-- Images -->
      <div class="mb-3">
        <label for="image_main" class="form-label">Image Principale</label>
        <?php if (!empty($projet['image_main'])): ?>
            <div class="mb-2">
                <img src="/images/projets/<?= htmlspecialchars($projet['image_main']) ?>" alt="Image principale" style="max-height: 100px; border-radius: 8px;">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="image_main" name="image_main" accept="image/*">
        <small class="text-muted">Laissez vide pour conserver l'image actuelle.</small>
      </div>

      <div class="mb-3">
        <label for="image_2" class="form-label">Image Secondaire 1</label>
        <?php if (!empty($projet['image_2'])): ?>
            <div class="mb-2">
                <img src="/images/projets/<?= htmlspecialchars($projet['image_2']) ?>" alt="Image secondaire 1" style="max-height: 100px; border-radius: 8px;">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="image_2" name="image_2" accept="image/*">
      </div>

      <div class="mb-3">
        <label for="image_3" class="form-label">Image Secondaire 2</label>
        <?php if (!empty($projet['image_3'])): ?>
            <div class="mb-2">
                <img src="/images/projets/<?= htmlspecialchars($projet['image_3']) ?>" alt="Image secondaire 2" style="max-height: 100px; border-radius: 8px;">
            </div>
        <?php endif; ?>
        <input type="file" class="form-control" id="image_3" name="image_3" accept="image/*">
      </div>

      <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
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
            // Ajustement initial (pratique pour l'édition)
            descriptionField.style.height = "auto";
            descriptionField.style.height = (descriptionField.scrollHeight) + "px";
        }
    });
  </script>
</body>
</html>
