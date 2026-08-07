<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

$conn = new mysqli("db", "root", "SoftiP24", "africa_db");
if ($conn->connect_error) die("Échec de la connexion : " . $conn->connect_error);

$sql = "SELECT * FROM projets ORDER BY nom ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Gérer les projets</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="../assets/styles.css">
</head>
<body class="bg-dark text-light">
  <div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Gestion des Projets</h2>
      <div>
        <a href="admin_add_projet.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Ajouter un projet</a>
        <a href="../admin/admin_dashboard.php" class="btn btn-secondary">Retour au Dashboard</a>
      </div>
    </div>
    
    <table class="table table-dark table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nom du Projet</th>
          <th>Slug (URL)</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nom']) ?></td>
              <td><?= htmlspecialchars($row['slug']) ?></td>
              <td>
                <a href="admin_edit_projet.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm"><i class="bi bi-pencil"></i> Modifier</a>
                <a href="admin_delete_projet.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce projet ?');"><i class="bi bi-trash"></i> Supprimer</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="4" class="text-center">Aucun projet trouvé.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
