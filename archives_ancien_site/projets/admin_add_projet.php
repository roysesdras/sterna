<?php
session_start();
if (!isset($_SESSION["username"])) {
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
    <form action="traitement_insert_projet.php" method="post">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom du Projet</label>
        <input type="text" class="form-control" id="nom" name="nom" required>
      </div>
      <div class="mb-3">
        <label for="slug" class="form-label">Slug (identifiant URL, ex: educmoi, camp-ecsi)</label>
        <input type="text" class="form-control" id="slug" name="slug" required>
      </div>
      <button type="submit" class="btn btn-success">Enregistrer le projet</button>
      <a href="admin_projets.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</body>
</html>
