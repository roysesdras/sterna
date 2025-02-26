<?php
require_once('config/db.php');

// Récupérer les missions
$sql_missions = "SELECT * FROM missions";
$result_missions = $conn->query($sql_missions);
$missions = [];
if ($result_missions->num_rows > 0) {
    while ($row = $result_missions->fetch_assoc()) {
        $missions[] = $row;
    }
}

// Récupérer les actualites
$sql_actualites = "SELECT * FROM actualites WHERE end_date < CURDATE() ORDER BY end_date DESC LIMIT 6";
$result_actualites = $conn->query($sql_actualites);
$actualites = [];
if ($result_actualites->num_rows > 0) {
    while ($row = $result_actualites->fetch_assoc()) {
        $actualites[] = $row;
    }
}
?>

<?php require_once ('config/head.php'); ?>

<body>
    <?php require_once ('config/mode_theme.php'); ?>
    <?php require_once ('config/navbar.php'); ?>
    <?php require_once ('config/carousel.php'); ?>
    <?php // require_once ('config/popup.php'); ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9 order-md-1 order-2 pb-4">
                    <h3 class="fst-italic border-bottom comic-neue-bold">&nbsp;<i class="bi bi-newspaper"></i>&nbsp; Nos Actualités</h3>
                <div class="row">
                    <?php  require_once ('config/actualite.php'); ?>
                </div>

                <div class="col-md-12">
                    <a href="./actualite/toutes_les_actualites.php" class=" comic-neue-regular">Voir toutes les actualités</a>
                </div>

                    <?php  require_once ('config/newsletter.php'); ?>

                    <?php  require_once ('config/partenaire.php'); ?>


                    <h3 class="pt-1 mb-2 fst-italic comic-neue-bold border-bottom"><i class="fa-solid fa-gears"></i>&nbsp; Secteurs d'Interventions</h3>
                    <?php require_once ('config/secteur_intervention.php'); ?>
                    

                    <div class="col-md-12" id="temoignage">
                        <h3 class="pt-4 fst-italic border-bottom comic-neue-bold">&nbsp;<i class="fas fa-quote-left"></i>&nbsp; Témoignages</h3>
                        <?php require_once('config/temoignage.php'); ?>
                    </div>
            </div> 

            <div class="col-md-3 order-md-2 order-1">
                <div class="position-sticky" style="top: 1rem">
                        <h3 class="fst-italic border-bottom comic-neue-bold">&nbsp;<i class="bi bi-alarm"></i>&nbsp; Événements</h3> 
                    <div class="row mb-3">
                        <?php  require_once ('config/evene.php'); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php  require_once('config/footer.php'); ?>

</body>
</html>

<?php
// Fermeture de la connexion à la base de données
$conn->close();
?>
