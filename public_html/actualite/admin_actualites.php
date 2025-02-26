<?php
    session_start();
    $conn = new mysqli('localhost', 'u694220522_sterna_africa', '@sterna_Africa225', 'u694220522_africa_db');
    if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
    }

   // Charger seulement la dernière actualité au début
   $sql = "SELECT * FROM actualites ORDER BY start_date DESC LIMIT 3";
   $result = $conn->query($sql);

    // Récupérer le nombre total d'actualités
    $sql_count = "SELECT COUNT(*) as total FROM actualites";
    $result_count = $conn->query($sql_count);

    $total_actualites = 0;
    if ($result_count) {
        $row = $result_count->fetch_assoc();
        $total_actualites = $row['total'];
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualite Tableau de bord</title>
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="icon">
    <link href="../assets/img/logos/sternaofficiel-2.png" rel="apple-touch-icon">
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .thumbnail {
            max-height: 100px; /* Taille maximale en hauteur */
            max-width: 150px;  /* Taille maximale en largeur */
            width: auto;       /* Ajustement proportionnel de la largeur */
            height: auto;      /* Ajustement proportionnel de la hauteur */
        }

        /* Styles spécifiques pour les images insérées dans les descriptions TinyMCE */
        .description img {
            max-height: 100px; /* Taille maximale en hauteur */
            max-width: 150px;  /* Taille maximale en largeur */
            width: auto;       /* Ajustement proportionnel de la largeur */
            height: auto;      /* Ajustement proportionnel de la hauteur */
        }

        /* @media screen and (max-width: 768px) {
            .table-responsive {
                overflow-x: auto;
                display: block;
                white-space: nowrap;
            }
        } */

    </style>
</head>
<body>
    <?php include_once ('../inclusion/mode_theme.php'); ?>
    <div class="container-fluid">
        <p class="comic-neue-regular">Nombre d'actualités disponibles : <?= $total_actualites ?></p>
        <?php if (isset($_GET['message'])) { echo "<div class='alert alert-info comic-neue-regular'>{$_GET['message']}</div>"; } ?>
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark comic-neue-bold">
                    <tr>
                        <th>ID</th>
                        <th>Titre</th>
                        <th>Description</th>
                        <th>Début</th>
                        <th>Fin</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    
                    if ($result->num_rows > 0) {
                        while ($actualite = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>{$actualite['id']}</td>";
                            echo "<td>{$actualite['title']}</td>";
                            // echo "<td class='description'>{$actualite['description']}</td>";
                            echo "<td class='description'>" . substr($actualite['description'], 0, 450) . "...</td>"; 
                            echo "<td>" . date('d/m/y', strtotime($actualite['start_date'])) . "</td>";
                            echo "<td>" . date('d/m/y', strtotime($actualite['end_date'])) . "</td>";
                            echo "<td><img src='../images/{$actualite['image']}' alt='Image de l\'actualité' class='thumbnail'></td>";
                            echo "<td>";
                            echo "<a href='admin_edit_actualite.php?id={$actualite['id']}' class='btn btn-warning btn-sm comic-neue-regular me-2'><i class='bi bi-pencil-square'></i> </a> ";
                            echo "<a href='admin_delete_actualite.php?id={$actualite['id']}' class='btn btn-danger btn-sm comic-neue-regular' onclick=\"return confirm('Êtes-vous sûr de vouloir supprimer cette actualité ?');\"><i class='bi bi-trash'></i> </a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center comic-neue-regular'>Aucune actualité trouvée.</td></tr>"; 
                    }
                    $conn->close();
                ?>
                </tbody>
            </table>
            <?php if ($total_actualites > 1): ?>
                <div class="mb-4">
                    <a id="load-more" style="color:#17a2b8; cursor:pointer;">Afficher plus</a>
                </div>
            <?php endif; ?>

            <div class="mb-4">
                <a href="admin_add_actualite.php" class="btn btn-success btn-sm comic-neue-regular">Ajout nouvelle actualité</a> ou 
                <a href="https://sternaafrica.org/admin/admin_dashboard.php" class="btn btn-outline-info btn-sm comic-neue-regular">Retour</a>
                <a href="../admin/admin_logout.php" class="btn btn-danger btn-sm float-end comic-neue-regular">Se déconnecter</a>
            </div>

            <script>
                let offset = 3; // Commence après les 2 premières actualités

                document.addEventListener("DOMContentLoaded", function () {
                    let loadMoreBtn = document.getElementById("load-more"); // Correction ici

                    if (loadMoreBtn) { // Vérifier si le bouton existe
                        loadMoreBtn.addEventListener("click", function () {
                            fetch(`load_more_actualites.php?offset=${offset}`)
                                .then(response => response.text())
                                .then(data => {
                                    if (data.trim() !== "") {
                                        document.querySelector("tbody").insertAdjacentHTML("beforeend", data);
                                        offset += 1;
                                    } else {
                                        loadMoreBtn.style.display = "none"; // Cacher le bouton s'il n'y a plus d'actualités
                                    }
                                })
                                .catch(error => console.error("Erreur AJAX :", error));
                        });
                    }
                });
            </script>
    </div>

    <?php require_once('../config/footer_2.php'); ?>
</body>
</html>
