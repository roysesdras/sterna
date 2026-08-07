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

    <?php include __DIR__ . '/config/header.php'; ?>

    <?php include __DIR__ . '/config/nav.php'; ?>

    <main class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-3 gap-12 items-start">
        <?php include __DIR__ . '/config/actu.php'; ?>
        <?php include __DIR__ . '/config/agenda.php'; ?>
    </main>

    <?php include __DIR__ . '/config/about_section.php'; ?>

    <?php include __DIR__ . '/config/secteur_intervention.php'; ?>

    <?php include __DIR__ . '/config/impact.php'; ?>

    <?php include __DIR__ . '/config/presse.php'; ?>

    <?php include __DIR__ . '/config/bureau_inter.php'; ?>

    <?php include __DIR__ . '/config/temoignage.php'; ?>

    <?php include __DIR__ . '/config/footer.php'; ?>

    <footer class="relative overflow-hidden py-8" style="background: linear-gradient(135deg, #0f277e 0%, #071952 100%);">
    
    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(white 1.5px, transparent 1.5px); background-size: 30px 30px;"></div>

    <div class="max-w-7xl mx-auto px-2 relative z-10">
        <div class="flex flex-col md:flex-row items-center justify-between gap-6">
            
            <div class="flex flex-col md:flex-row items-center gap-2 md:gap-4">
                <img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Sterna" class="h-6 w-auto brightness-0 invert opacity-80 mb-2 md:mb-0">
                <p class="text-[11px] font-bold text-white/40 uppercase tracking-[0.2em]">
                    © 2026 Sterna Africa — <span class="text-white/80">Wherever Needed</span>
                </p>
            </div>
        </div>
    </div>
</footer>

</body>

</html>