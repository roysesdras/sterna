<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Récupérer uniquement les missions de l'année en cours
$year = date('Y');

$sql_missions = "
    SELECT *
    FROM missions
    WHERE start_date >= '{$year}-01-01'
      AND start_date <  '" . ($year + 1) . "-01-01'
    ORDER BY start_date ASC
";


$result_missions = $conn->query($sql_missions);

$missions = [];
if ($result_missions && $result_missions->num_rows > 0) {
    while ($row = $result_missions->fetch_assoc()) {
        $missions[] = $row;
    }
}

// Récupérer les actualites
$today = date('Y-m-d');
$sql_actualites = "SELECT * FROM actualites 
                   WHERE end_date <= '$today' 
                   ORDER BY end_date DESC 
                   LIMIT 8";

$result_actualites = $conn->query($sql_actualites);
$actualites = [];
if ($result_actualites->num_rows > 0) {
    while ($row = $result_actualites->fetch_assoc()) {
        $actualites[] = $row;
    }
}
?>

<?php include __DIR__ . '/config/head.php'; ?>

<body class="bg-gray-100 font-sans text-gray-800">

    <?php include __DIR__ . '/config/nav.php'; ?>

    <?php include __DIR__ . '/config/header.php'; ?>

    <?php include __DIR__ . '/config/about_section.php'; ?>

    <?php include __DIR__ . '/config/pont_solidaire.php'; ?>

    <?php include __DIR__ . '/config/secteur_intervention.php'; ?>

    <main class="relative bg-sterna-blue">
        <!-- SVG de séparation en haut de la section -->
        <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 fill-current text-gray-100">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
            <?php 
            include __DIR__ . '/config/actu.php'; 
            include __DIR__ . '/config/agenda.php'; 
            ?>
       </div>
    </main>

    <?php include __DIR__ . '/config/presse.php'; ?>

    <?php // include __DIR__ . '/config/bureau_inter.php'; ?>

    <?php include __DIR__ . '/config/partenaire.php'; ?>

    <?php include __DIR__ . '/config/footer.php'; ?>

    <?php include __DIR__ . '/config/footer_2.php'; ?>
</body>

</html>