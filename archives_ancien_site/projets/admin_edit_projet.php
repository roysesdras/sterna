<?php
session_start();
if (!isset($_SESSION["username"])) {
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
    <form action="traitement_edit_projet.php" method="post">
      <input type="hidden" name="id" value="<?= $projet['id'] ?>">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom du Projet</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($projet['nom']) ?>" required>
      </div>
      <div class="mb-3">
        <label for="slug" class="form-label">Slug (identifiant URL)</label>
        <input type="text" class="form-control" id="slug" name="slug" value="<?= htmlspecialchars($projet['slug']) ?>" required>
      </div>
      <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
      <a href="admin_projets.php" class="btn btn-secondary">Annuler</a>
    </form>
  </div>
</body>
</html>
