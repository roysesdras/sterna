<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
session_start();

// Vérifie si l'utilisateur est un administrateur
if (!isset($_SESSION['admin'])) {
    header('Location: ./admin_login.php');
    exit();
}

// Inclure le fichier de connexion à la base de données
require_once('../config/db.php');

$currentYear = date('Y');
$selectedYear = isset($_GET['year']) ? $_GET['year'] : $currentYear;

// 🔹 Récupérer toutes les missions (du plus récent au plus ancien)
$limit = 3;
$sql = "SELECT * FROM missions ORDER BY end_date DESC LIMIT $limit";
$result = $conn->query($sql);

if (!$result) {
    die("Erreur dans la requête SQL : " . $conn->error);
}

// 🔹 Stocker les missions dans un tableau
$missions = [];
while ($row = $result->fetch_assoc()) {
    $missions[] = $row;
}

// 🔹 Filtrer les missions par année
$missionsOfYear = array_filter($missions, function ($mission) use ($selectedYear) {
    return date('Y', strtotime($mission['start_date'])) == $selectedYear;
});

// 🔹 Générer la liste des années disponibles
$availableYears = array_unique(array_map(function ($m) {
    return date('Y', strtotime($m['start_date']));
}, $missions));
rsort($availableYears); // années en ordre décroissant

// 🔹 Récupérer le nombre total d'activités (missions)
$sql_count = "SELECT COUNT(*) as total FROM missions";
$result_count = $conn->query($sql_count);

$total_activites = 0;
if ($result_count) {
    $row = $result_count->fetch_assoc();
    $total_activites = $row['total'];
}

// 🔹 Nom de l’admin
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
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title><?= htmlspecialchars($admin_name); ?> : admin</title>
    <!-- all css -->
</head>

<body>
    <div class="container-fluid">
        <h2 class="mt-1 comic-neue-bold">Hey <?php echo htmlspecialchars($admin_name); ?>, ravi de te voir ici ! 😊 </h2>
        <h3 class="comic-neue-regular">Qu'allons-nous faire aujourd'hui pour faire avancer la solidarité ? 🤝🎯</h3>
        <div class="mb-3 comic-neue-regular">
            <p> Nombre d'activités disponibles : <?= $total_activites ?></p>

            <?php if (isset($_GET['message'])) {
                echo "<div class='alert alert-info'>{$_GET['message']}</div>";
            } ?>

            <div class="mb-4">
                <a href="../evenement/admin_add_mission.php" class="btn btn-success btn-sm comic-neue-regular">Ajout nouvelle activité</a> ou
                <a href="../actualite/admin_actualites.php" class="btn btn-outline-info btn-sm comic-neue-regular">Gérer les actualités</a> ou encore
                <a class="btn btn-outline-warning me-5 btn-sm comic-neue-regular" data-bs-toggle="modal" data-bs-target="#exampleModal">Ajouter une antenne</a>

                <a href="../evenement/edit_temoignage.php" class="btn btn-outline-secondary btn-sm comic-neue-regular">Corriger les témoignages</a>
            </div>

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
                    <?php if (count($missionsOfYear) > 0): ?>
                        <?php foreach ($missionsOfYear as $mission): ?>
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
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Aucune mission disponible pour l'année <?php echo $selectedYear; ?>.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>

            </table>

            <div class="mb-3">
                <strong>📅 Autres années :</strong>
                <?php foreach ($availableYears as $year): ?>
                    <?php if ($year != $selectedYear): ?>
                        <a href="?year=<?php echo $year; ?>" class="btn btn-outline-secondary btn-sm"><?php echo $year; ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>


            <a href="../evenement/admin_add_mission.php" class="btn btn-success btn-sm comic-neue-regular">Ajout nouvelle activité</a> ou
            <a href="../actualite/admin_actualites.php" class="btn btn-outline-info btn-sm comic-neue-regular">Gérer les actualités</a> ou encore
            <a class="btn btn-outline-warning me-5 btn-sm comic-neue-regular" data-bs-toggle="modal" data-bs-target="#exampleModal">Ajouter une antenne</a>

            <a href="../evenement/question_temoignage.php" class="btn btn-outline-secondary btn-sm comic-neue-regular">Ajouter question temoignage</a>

            <a href="admin_logout.php" class="btn btn-danger btn-sm float-end comic-neue-regular">Se déconnecter</a>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <form action="traitement_insert_antenne.php" method="post">
                            <h3 class="modal-title fs-5 mb-3" id="exampleModalLabel">Ajouter une Nouvelle Antenne</h3>

                            <div class="mb-3">
                                <label for="nom_antenne" class="form-label">Nom de l'antenne :</label>
                                <input type="text" class="form-control" id="nom_antenne" name="nom_antenne" required>
                            </div>

                            <button type="submit" class="btn btn-success float-end">Ajouter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <?php require_once('../config/footer_2.php'); ?>

</body>

</html>

<?php
$conn->close();
?>