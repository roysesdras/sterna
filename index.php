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
                   LIMIT 6";

$result_actualites = $conn->query($sql_actualites);
$actualites = [];
if ($result_actualites->num_rows > 0) {
    while ($row = $result_actualites->fetch_assoc()) {
        $actualites[] = $row;
    }
}
?>

<?php require_once('config/head.php'); ?>

<body>
    <?php require_once('config/navbar.php'); ?>
    <?php require_once('config/carousel.php'); ?>
    <?php // require_once('config/popup.php');
    ?>

    <div class="container-fluide">
        <?php include_once('config/about_section.php');
        ?>
    </div>

    <!-- domaine activite -->
    <div class="secteur-itervention container-fluide mb-6" id="domaine">
        <!-- <h3 class="sterna-title-modern">Nos Domaines</h3> -->
        <?php include_once('config/secteur_intervention.php');
        ?>
    </div>

    <!-- impact -->
    <?php include_once('config/impact.php');
    ?>

    <div class="container-fluid bg-sterna-dark">
        <div style="margin-bottom: 4rem;">
            <h3 class="sterna-title-modern">événements</h3>
            <div class="row">
                <?php
                require_once('config/evene.php');
                ?>
            </div>
        </div>

        <div style="margin-bottom: 4rem;" id="ils_parlent">
            <h3 class="sterna-title-modern">presse</h3>
            <?php require_once('config/presse.php');
            ?>
        </div>

        <div style="margin-bottom: 4rem;" id="actualites">
            <h3 class="sterna-title-modern">Actualités</h3>
            <div class="row">
                <?php require_once('config/actualite.php');
                ?>
            </div>
            <div class="col-md-12 mb-2">
                <p><a href="./actualite/toutes_les_actualites.php" class="text-yellow-500 hover:text-yellow-400">Voir toutes les actualités</a></p>
            </div>
        </div>

        <!-- Equipe membre du bureau -->
        <div class="mb-4">
            <h3 class="sterna-title-modern">Équipe</h3>
            <?php include_once('config/bureau_inter.php'); ?>
        </div>

        <div class="mb-4">
            <!-- Temoignage -->
            <h3 class="sterna-title-modern">Témoignages</h3>
            <?php include_once('config/temoignage.php'); ?>
        </div>


        <!-- Partenaire -->
        <h3 class="sterna-title-modern">Nos Partenaires</h3>
        <?php require_once('config/partenaire.php'); ?>

    </div>

    <!-- Footer -->
    <div class="footer">
        <?php require_once('config/footer.php'); ?>
    </div>

    <!-- AI Sidebar -->
    <?php require_once('ai.php'); ?>


    <script>
        window.addEventListener('load', function() {
            if (typeof DigiStats === 'undefined') return;

            // ── 1. TEMPS SUR LA HOMEPAGE ─────────────────────────────
            // tracker.js envoie déjà page_view + time_update automatiquement.
            // On ajoute des jalons de temps pour savoir JUSQU'OÙ les gens restent.
            // Jalon 15s  = le design a accroché l'attention
            // Jalon 30s  = l'utilisateur explore
            // Jalon 60s  = engagement réel
            // Jalon 120s = très engagé

            var jalons = [15, 30, 60, 120];
            jalons.forEach(function(sec) {
                setTimeout(function() {
                    DigiStats.track('homepage_time_jalon', {
                        seconds: sec,
                        label: sec + 's sur homepage'
                    });
                }, sec * 1000);
            });

            // ── 2. CHAT IA STERNA ─────────────────────────────────────
            // Adaptez le sélecteur selon votre bouton IA.
            // Exemples courants : '#chat-btn', '.ia-toggle', '#sterna-ai-btn'
            // Remplacez '#chat-ia-btn' par l'id ou la classe réelle de votre bouton.

            // ── Bouton "Chat IA" dans le dock ────────────────────────
            // <button class="dock-item" onclick="openSidebar()">
            // On enveloppe openSidebar() pour tracker l'ouverture
            var _origOpenSidebar = window.openSidebar;
            window.openSidebar = function() {
                DigiStats.track('ia_chat_opened', {
                    source: 'homepage'
                });
                if (_origOpenSidebar) _origOpenSidebar();
            };

            // ── Bouton "Envoyer" dans le chat IA ─────────────────────
            // <button onclick="askSternaIA()" id="sendBtn">
            // On enveloppe askSternaIA() pour tracker chaque message
            var premierMessage = true;
            var _origAskSterna = window.askSternaIA;
            window.askSternaIA = function() {
                var input = document.getElementById('aiInput');
                var msg = input ? input.value.trim() : '';

                if (msg.length === 0) {
                    // Message vide, on laisse la fonction originale gérer
                    if (_origAskSterna) _origAskSterna();
                    return;
                }

                if (premierMessage) {
                    DigiStats.track('ia_chat_first_message', {
                        source: 'homepage'
                    });
                    premierMessage = false;
                }

                DigiStats.track('ia_chat_message_sent', {
                    source: 'homepage',
                    message_length: msg.length
                });

                if (_origAskSterna) _origAskSterna();
            };

            // Aussi sur la touche Entrée dans l'input #aiInput
            var aiInput = document.getElementById('aiInput');
            if (aiInput) {
                aiInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        // askSternaIA() sera appelé par le comportement natif,
                        // notre wrapper ci-dessus s'en chargera automatiquement
                    }
                });
            }
        });
    </script>

</body>

</html>