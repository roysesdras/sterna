<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Charger seulement la dernière actualité au début
$sql = "SELECT * FROM actualites ORDER BY start_date DESC LIMIT 5";
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
    <link rel="stylesheet" href="../assets/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .thumbnail {
            width: 80px;
            /* On fixe une largeur fixe pour ne pas casser le tableau */
            height: 60px;
            object-fit: cover;
            /* L'image remplit le carré sans être déformée */
            border-radius: 5px;
        }

        /* Pour éviter que le texte ne soit trop large */
        td {
            vertical-align: middle;
            /* Centre le contenu verticalement */
        }
    </style>
</head>

<body>

    <div class="container-fluid mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 comic-neue-bold">Tableau de bord Actualités</h2>
            <span class="badge bg-primary comic-neue-regular">Total : <?= $total_actualites ?></span>
        </div>

        <?php if (isset($_GET['message'])) {
            echo "<div class='alert alert-info comic-neue-regular'>{$_GET['message']}</div>";
        } ?>

        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover align-middle">
                <thead class="table-dark comic-neue-bold text-center">
                    <tr>
                        <th style="width: 5%;">ID</th>
                        <th style="width: 20%;">Titre</th>
                        <th style="width: 30%;">Aperçu Description</th>
                        <th style="width: 10%;">Début</th>
                        <th style="width: 10%;">Fin</th>
                        <th style="width: 10%;">Image</th>
                        <th style="width: 15%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($actualite = $result->fetch_assoc()) {
                            // 1. Nettoyage du HTML (strip_tags) pour éviter de casser le tableau
                            // 2. Raccourcissement propre à 100 caractères
                            $description_clean = strip_tags($actualite['description']);
                            $description_short = mb_strlen($description_clean) > 100 ? mb_substr($description_clean, 0, 100) . "..." : $description_clean;

                            // Formatage des dates (gestion des erreurs si date vide)
                            $date_debut = $actualite['start_date'] ? date('d/m/y', strtotime($actualite['start_date'])) : '-';
                            $date_fin = $actualite['end_date'] ? date('d/m/y', strtotime($actualite['end_date'])) : '-';

                            echo "<tr>";
                            echo "<td class='text-center'>{$actualite['id']}</td>";
                            echo "<td class='fw-bold'>{$actualite['title']}</td>";
                            echo "<td class='text-muted small'>{$description_short}</td>";
                            echo "<td class='text-center'>{$date_debut}</td>";
                            echo "<td class='text-center'>{$date_fin}</td>";

                            // Vérification simple si l'image existe (sinon placeholder)
                            $img_path = "../images/{$actualite['image']}";
                            echo "<td class='text-center'><img src='{$img_path}' alt='Img' class='thumbnail border'></td>";

                            echo "<td class='text-center'>";
                            echo "<div class='btn-group' role='group'>";
                            echo "<a href='admin_edit_actualite.php?id={$actualite['id']}' class='btn btn-warning btn-sm' title='Modifier'><i class='bi bi-pencil-square'></i></a>";
                            echo "<a href='admin_delete_actualite.php?id={$actualite['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Êtes-vous sûr ?');\" title='Supprimer'><i class='bi bi-trash'></i></a>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7' class='text-center p-4'>Aucune actualité trouvée.</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div> <?php if ($total_actualites > 1): ?>
            <div class="mb-4 text-left">
                <a id="load-more" style="cursor:pointer;">Afficher plus d'actualités</a>
            </div>
        <?php endif; ?>

        <div class="d-flex justify-content-between mb-5">
            <a href="https://sternaafrica.org/admin/admin_dashboard.php" class="btn btn-secondary btn-sm">← Retour Dashboard</a>
            <a href="admin_add_actualite.php" class="btn btn-success btn-sm"><i class="bi bi-plus-circle"></i> Nouvelle actualité</a>
            <a href="../admin/admin_logout.php" class="btn btn-danger btn-sm">Déconnexion</a>
        </div>

        <script>
            let offset = 3;
            document.addEventListener("DOMContentLoaded", function() {
                let loadMoreBtn = document.getElementById("load-more");
                if (loadMoreBtn) {
                    loadMoreBtn.addEventListener("click", function() {
                        fetch(`load_more_actualites.php?offset=${offset}`)
                            .then(response => response.text())
                            .then(data => {
                                if (data.trim() !== "") {
                                    document.querySelector("tbody").insertAdjacentHTML("beforeend", data);
                                    offset += 1; // Attention, ton script PHP semble renvoyer 1 ligne par 1 ligne ? Sinon ajuste l'offset.
                                } else {
                                    loadMoreBtn.style.display = "none";
                                    loadMoreBtn.parentElement.innerHTML = "<span class='text-muted'>Fin des résultats</span>";
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