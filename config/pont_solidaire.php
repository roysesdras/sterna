<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Récupération dynamique des volontaires validés
$sql_pont = "SELECT * FROM pont_solidaire WHERE statut = 'valide' ORDER BY id DESC";
$result_pont = $conn->query($sql_pont);

$volontaires_list = [];
if ($result_pont && $result_pont->num_rows > 0) {
    while ($row = $result_pont->fetch_assoc()) {
        $volontaires_list[] = $row;
    }
}
?>
<!-- Section Pont Solidaire -->
<section class="py-12 md:py-16 bg-sterna-yellow relative overflow-hidden mt-12" id="pont-solidaire">
    <!-- SVG de séparation en haut de la section -->
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 text-gray-100 fill-current text-gray-100">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
    <div class="max-w-7xl mx-auto px-4 relative z-10">
        
        <!-- En-tête de section -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
            <div>
                <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-sterna-blue text-white font-bold text-xs uppercase tracking-wider mb-3 shadow-sm">
                    <i class="fi fi-rr-globe"></i> Mobilité Internationale & Récits
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-black uppercase tracking-tighter border-l-8 border-sterna-yellow pl-6">
                    Pont <span class="text-black">Solidaire</span>
                </h2>
                <p class="text-gray-800 text-sm md:text-base mt-3 max-w-2xl pl-6 font-medium">
                    Découvrez les témoignages inspirants de nos volontaires engagés dans les échanges réciproques Nord-Sud, Sud-Nord et Sud-Sud.
                </p>
            </div>

            <!-- Filtres & Boutons de Navigation -->
            <div class="flex flex-wrap items-center justify-between md:justify-end gap-3">
                <!-- CTA pour proposer un récit 
                <a href="/recit_volontaire.php" class="px-4 py-2 bg-sterna-blue hover:bg-blue-900 text-white font-black text-xs uppercase tracking-wider rounded-full shadow-md hover:shadow-lg transition-all flex items-center gap-2">
                    <i class="fi fi-rr-edit"></i> Proposer mon récit
                </a>
                -->

                <!-- Onglets de filtre (Tous, Sud->Nord, Nord->Sud, Sud->Sud) -->
                <div class="bg-white/80 backdrop-blur-md p-1 rounded-full flex gap-1 text-xs md:text-sm font-bold shadow-sm border border-gray-200/50">
                    <button onclick="filterPont('all')" id="tab-pont-all" class="pont-tab active px-3.5 py-1.5 rounded-full transition-all duration-300 bg-sterna-blue text-white shadow">
                        Tous
                    </button>
                    <button onclick="filterPont('sud-nord')" id="tab-pont-sud-nord" class="pont-tab px-3.5 py-1.5 rounded-full transition-all duration-300 text-gray-700 hover:text-sterna-blue">
                        Sud <i class="fi fi-rr-arrow-right text-[9px] mx-0.5"></i> Nord
                    </button>
                    <button onclick="filterPont('nord-sud')" id="tab-pont-nord-sud" class="pont-tab px-3.5 py-1.5 rounded-full transition-all duration-300 text-gray-700 hover:text-sterna-blue">
                        Nord <i class="fi fi-rr-arrow-right text-[9px] mx-0.5"></i> Sud
                    </button>
                    <button onclick="filterPont('sud-sud')" id="tab-pont-sud-sud" class="pont-tab px-3.5 py-1.5 rounded-full transition-all duration-300 text-gray-700 hover:text-sterna-blue">
                        Sud <i class="fi fi-rr-arrow-right text-[9px] mx-0.5"></i> Sud
                    </button>
                </div>

                <!-- Boutons Flèches Swiper Desktop/Tablette -->
                <div class="hidden sm:flex items-center gap-2">
                    <button onclick="scrollPontSlider(-1)" class="w-9 h-9 rounded-full bg-white border border-gray-200 shadow-md text-sterna-blue flex items-center justify-center hover:bg-sterna-blue hover:text-white transition-all duration-300 focus:outline-none" aria-label="Précédent">
                        <i class="fi fi-rr-angle-left text-base"></i>
                    </button>
                    <button onclick="scrollPontSlider(1)" class="w-9 h-9 rounded-full bg-white border border-gray-200 shadow-md text-sterna-blue flex items-center justify-center hover:bg-sterna-blue hover:text-white transition-all duration-300 focus:outline-none" aria-label="Suivant">
                        <i class="fi fi-rr-angle-right text-base"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Slider Swipable des Volontaires (Dynamique) -->
        <div class="relative group">
            <div id="pont-slider" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide py-4 px-1 scroll-smooth">

                <?php if (!empty($volontaires_list)): ?>
                    <?php foreach ($volontaires_list as $volontaire): ?>
                        <?php 
                        // Normalisation du type de relation pour la classe CSS de filtre
                        $relation_type = $volontaire['type_relation'];
                        $filter_class = str_replace('_', '-', $relation_type); // ex: sud_nord -> sud-nord

                        // Détermination de l'année ou de la période
                        $annee = '2025';
                        if (!empty($volontaire['date_debut'])) {
                            $annee = date('Y', strtotime($volontaire['date_debut']));
                        }

                        // Troncature du récit à environ 150 caractères
                        $recit_full = strip_tags($volontaire['recit']);
                        $recit_excerpt = (mb_strlen($recit_full) > 145) ? mb_substr($recit_full, 0, 145) . '...' : $recit_full;

                        // Libellé du badge
                        $badge_bg = 'bg-blue-50 text-sterna-blue border-blue-100';
                        $dot_bg = 'bg-sterna-blue';
                        if ($relation_type === 'nord_sud') {
                            $badge_bg = 'bg-amber-50 text-amber-900 border-amber-100';
                            $dot_bg = 'bg-sterna-yellow';
                        } elseif ($relation_type === 'sud_sud') {
                            $badge_bg = 'bg-emerald-50 text-emerald-900 border-emerald-100';
                            $dot_bg = 'bg-emerald-600';
                        }
                        ?>

                        <!-- Carte Volontaire Dynamic -->
                        <div class="pont-card <?php echo $filter_class; ?> min-w-[280px] sm:min-w-[340px] md:min-w-[380px] snap-start bg-gray-100 rounded-3xl p-4 shadow-lg hover:shadow-lg transition-all duration-300 flex flex-col justify-between group/card">
                            <div>
                                <!-- Tag Direction -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5 border <?php echo $badge_bg; ?>">
                                        <span class="w-2 h-2 rounded-full <?php echo $dot_bg; ?>"></span>
                                        <?php echo htmlspecialchars($volontaire['pays_provenance']); ?> 
                                        <i class="fi fi-rr-arrow-right text-[10px]"></i> 
                                        <?php echo htmlspecialchars($volontaire['pays_reception']); ?>
                                    </span>
                                    <span class="text-xs font-semibold text-gray-400"><?php echo $annee; ?></span>
                                </div>

                                <!-- Image & Profil -->
                                <div class="relative mb-5 overflow-hidden rounded-2xl h-64 bg-gray-900 flex items-center justify-center">
                                    <!-- Image Principale Entière (non coupée) avec Lazy Loading -->
                                    <img src="<?php echo htmlspecialchars($volontaire['photo_volontaire']); ?>?v=<?php echo @filemtime($_SERVER['DOCUMENT_ROOT'] . $volontaire['photo_volontaire']); ?>" 
                                         alt="<?php echo htmlspecialchars($volontaire['nom_complet']); ?>" 
                                         loading="lazy"
                                         decoding="async"
                                         class="w-full h-full object-cover group-hover/card:scale-105 transition-transform duration-500">
                                         
                                    <div class="absolute inset-0 z-20 bg-gradient-to-t from-black/90 via-black/20 to-transparent pointer-events-none"></div>
                                    <div class="absolute z-30 bottom-3 left-3 right-3 text-white pointer-events-none">
                                        <h3 class="text-lg font-black leading-tight"><?php echo htmlspecialchars($volontaire['nom_complet']); ?></h3>
                                        <p class="text-xs text-sterna-yellow font-bold flex items-center gap-1 mt-0.5">
                                            <i class="fi fi-rr-building text-[10px]"></i>
                                            <?php echo htmlspecialchars(!empty($volontaire['structure_envoi']) ? $volontaire['structure_envoi'] : 'Volontaire Sterna Africa'); ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Extrait du récit (150 car.) -->
                                <p class="text-gray-600 text-sm leading-relaxed mb-6 font-medium">
                                    "<?php echo htmlspecialchars($recit_excerpt); ?>"
                                </p>
                            </div>

                            <!-- Lien Voir Plus -->
                            <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                                <a href="/recit_detail.php?id=<?php echo $volontaire['id']; ?>" class="text-sterna-blue hover:text-sterna-yellow font-bold text-sm inline-flex items-center gap-2 group-hover/card:translate-x-1 transition-all duration-300">
                                    Lire le récit complet
                                    <i class="fi fi-rr-arrow-right text-xs"></i>
                                </a>
                                <span class="w-8 h-8 rounded-full bg-sterna-blue/10 text-sterna-blue flex items-center justify-center text-xs">
                                    <i class="fi fi-rr-book-alt"></i>
                                </span>
                            </div>
                        </div>

                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="w-full py-12 text-center text-gray-500 bg-white rounded-3xl p-6">
                        <p class="text-base font-bold">Aucun récit de volontaire n'est disponible pour le moment.</p>
                        <a href="/recit_volontaire.php" class="inline-block mt-4 px-6 py-2.5 bg-sterna-blue text-white font-bold text-xs uppercase tracking-wider rounded-xl hover:bg-blue-900">
                            Soyez le premier à partager votre récit
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>

        <!-- Indicateur de swipe mobile -->
        <div class="flex items-center justify-center gap-2 mt-4 sm:hidden text-gray-600 text-xs font-bold">
            <i class="fi fi-rr-angle-left animate-bounce"></i>
            <span>Glissez pour voir plus de volontaires</span>
            <i class="fi fi-rr-angle-right animate-bounce"></i>
        </div>

    </div>
</section>

<!-- Styles & Scripts pour le Slider Swipable et Filtres -->
<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    #pont-slider.filter-sud-nord .pont-card:not(.sud-nord) { display: none !important; }
    #pont-slider.filter-nord-sud .pont-card:not(.nord-sud) { display: none !important; }
    #pont-slider.filter-sud-sud .pont-card:not(.sud-sud) { display: none !important; }
</style>

<script>
    function scrollPontSlider(direction) {
        const slider = document.getElementById('pont-slider');
        if (!slider) return;
        const scrollAmount = slider.clientWidth * 0.8;
        slider.scrollBy({
            left: direction * scrollAmount,
            behavior: 'smooth'
        });
    }

    function filterPont(category) {
        // Mise à jour des classes active sur les onglets
        document.querySelectorAll('.pont-tab').forEach(tab => {
            tab.classList.remove('bg-sterna-blue', 'text-white', 'shadow');
            tab.classList.add('text-gray-700');
        });

        const activeTab = document.getElementById('tab-pont-' + category);
        if (activeTab) {
            activeTab.classList.add('bg-sterna-blue', 'text-white', 'shadow');
            activeTab.classList.remove('text-gray-700');
        }

        // Filtration des cartes via CSS
        const slider = document.getElementById('pont-slider');
        if (slider) {
            // Retire toutes les classes de filtre actuelles
            slider.className = slider.className.replace(/\bfilter-[a-z-]+\b/g, '').trim();
            // Ajoute la nouvelle classe si ce n'est pas "all"
            if (category !== 'all') {
                slider.classList.add('filter-' + category);
            }
        }
    }
</script>
