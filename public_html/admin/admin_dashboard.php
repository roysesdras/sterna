<?php
session_start();

// Vérifie si l'utilisateur est un administrateur
if (!isset($_SESSION['admin'])) {
    header('Location: ./admin_login.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../config/db.php'); 

// Récupérer les missions
$sql = "SELECT * FROM missions";
$result = $conn->query($sql);

if (!$result) {
    die("Erreur dans la requête SQL : " . $conn->error);
}

// Récupérer le nombre total d'activités (missions)
$sql_count = "SELECT COUNT(*) as total FROM missions";
$result_count = $conn->query($sql_count);

$total_activites = 0;
if ($result_count) {
    $row = $result_count->fetch_assoc();
    $total_activites = $row['total'];
}

// Récupérer le nom de l'administrateur
$admin_name = isset($_SESSION['admin_name']) ? $_SESSION['admin_name'] : 'Admin';
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <!-- meta for SEO -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Favicons -->
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title><?= htmlspecialchars($admin_name); ?> : admin</title>
    <!-- all css -->
</head>
<body>
    <?php include_once ('../config/mode_theme.php'); ?>
    <div class="container-fluid">
        <h2 class="mt-1 comic-neue-bold">Hey <?php echo htmlspecialchars($admin_name); ?>, ravi de te voir ici ! 😊 </h2>
        <h3 class="comic-neue-regular">Qu'allons-nous faire aujourd'hui pour faire avancer la solidarité ? 🤝🎯</h3>
        <div class="mb-3 comic-neue-regular">
            <p> Nombre d'activités disponibles : <?= $total_activites ?></p>

            <?php if (isset($_GET['message'])) { echo "<div class='alert alert-info'>{$_GET['message']}</div>"; } ?>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>D.début</th>
                        <th>D.fin</th>
                        <th>Lieu</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($mission = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $mission['id']; ?></td>
                        <td><?php echo $mission['title']; ?></td>
                        <td><?php echo strlen($mission['description']) > 450 ? substr($mission['description'], 0, 450) . '...' : $mission['description']; ?></td>
                        <td><?php echo date('d/m/y', strtotime($mission['start_date'])); ?></td>
                        <td><?php echo date('d/m/y', strtotime($mission['end_date'])); ?></td>
                        <td><?php echo $mission['lieu']; ?></td>
                        <td><img src="../images/<?php echo $mission['image']; ?>" alt="Image de la mission" width="100"></td>
                        <td>
                            <a href="../evenement/admin_edit_mission.php?id=<?php echo $mission['id']; ?>" class="btn btn-warning btn-sm mb-2"><i class="bi bi-pencil-fill"></i></a>

                            <a href="admin_delete_mission.php?id=<?php echo $mission['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette mission ?');" class="btn btn-danger btn-sm mb-2"><i class="bi bi-trash-fill"></i></a>

                            <a href="../volunteer/volunteer_list.php?id=<?php echo $mission['id']; ?>" class="btn btn-info btn-sm mb-2"><i class="bi bi-person-lines-fill"></i></a>

                            <a href="download_volunteers_pdf.php?id=<?php echo $mission['id']; ?>" class="btn btn-success btn-sm mb-2"><i class="bi bi-file-earmark-pdf-fill"></i></a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <a href="../evenement/admin_add_mission.php" class="btn btn-success btn-sm comic-neue-regular">Ajout nouvelle activité</a> ou <a href="../actualite/admin_actualites.php" class="btn btn-outline-info btn-sm comic-neue-regular">Gérer les actualités</a>
            
            <a href="admin_logout.php" class="btn btn-danger btn-sm float-end comic-neue-regular">Se déconnecter</a>
        </div>
    </div>

    <?php require_once('../config/footer_2.php'); ?>

</body>
</html>

<?php
$conn->close();
?>
