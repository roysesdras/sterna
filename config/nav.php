<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
$antennes_list = [];
if (isset($conn)) {
    $res_ant = $conn->query("SELECT nom FROM antennes ORDER BY nom ASC");
    if ($res_ant && $res_ant->num_rows > 0) {
        while ($row = $res_ant->fetch_assoc()) {
            $antennes_list[] = $row['nom'];
        }
    }
}

$newsletters = [];
$rapports = [];

if (isset($conn)) {
    // Récupération des Bulletins (newsletters)
    $res_bull = $conn->query("SELECT annee, trimestre, pdf_link FROM rapports WHERE type_document = 'bulletin' ORDER BY annee DESC, trimestre DESC");
    if ($res_bull && $res_bull->num_rows > 0) {
        while ($row = $res_bull->fetch_assoc()) {
            $year_label = $row['annee'];
            $trimestre = !empty($row['trimestre']) ? $row['trimestre'] : 'T1';
            $pdf_path = $row['pdf_link'];
            
            if (!isset($newsletters[$year_label])) {
                $newsletters[$year_label] = [];
            }
            $newsletters[$year_label][$trimestre] = $pdf_path;
        }
    }

    // Récupération des Rapports Annuels
    $res_rap = $conn->query("SELECT annee, pdf_link FROM rapports WHERE type_document = 'rapport_annuel' ORDER BY annee DESC");
    if ($res_rap && $res_rap->num_rows > 0) {
        while ($row = $res_rap->fetch_assoc()) {
            $year_label = $row['annee'];
            $pdf_path = $row['pdf_link'];
            
            if (!isset($rapports[$year_label])) {
                $rapports[$year_label] = $pdf_path;
            }
        }
    }
}
?>
<nav class="bg-gray-100 shadow-lg top-0 z-50 text-gray-700">
    <div class="max-w-7xl mx-auto px-2 flex justify-between items-center h-14">

        <div class="flex items-center shrink-0 cursor-pointer group">
            <div class="transition-transform group-hover:scale-105 duration-300">
                <a href="/"><img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Logo sterna africa" class="h-14 md:h-14 w-auto object-contain"></a>
            </div>
        </div>

        <div class="hidden lg:flex space-x-3 font-bold text-[14px] uppercase items-center">
            <a href="/a-propos/" class="hover:text-[#ea750fff] transition whitespace-nowrap">A propos</a>
            <a href="/projets/" class="hover:text-[#ea750fff] transition whitespace-nowrap">Nos projets</a>
            <a href="/old/pages/missions.php" class="hover:text-[#ea750fff] transition whitespace-nowrap">Nos missions</a>
            <div class="relative group">
                <a href="/#evenements" class="hover:text-[#ea750fff] transition whitespace-nowrap flex items-center gap-1">
                    Nos événements <i class="fi fi-rr-angle-small-down"></i>
                </a>
                <div class="absolute top-full left-0 pt-4 w-56 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="bg-white border border-gray-100 shadow-xl rounded-xl overflow-hidden">
                        <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50">Festivals</div>
                        <a href="/old/pages/festival_alimenterre.php" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50">Festival Alimenterre</a>
                        <a href="/old/pages/festival_solidarite.php" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50">Festival des Solidarités</a>
                        <div class="px-4 py-2 text-[10px] font-black text-gray-400 uppercase tracking-widest bg-gray-50 border-t border-gray-100">Journées Int.</div>
                        <a href="/old/pages/jide.php" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50">Droits des Enfants</a>
                        <a href="/old/pages/jiv.php" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50">Volontariat</a>
                        <a href="/old/pages/jvf.php" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50">Journée du Volontatriat Français</a>
                    </div>
                </div>
            </div>

            <a href="/old/actualite/toutes_les_actualites.php" class="hover:text-[#ea750fff] transition whitespace-nowrap">Nos actions</a>

            <div class="relative group">
                <a href="#" class="hover:text-[#ea750fff] transition whitespace-nowrap flex items-center gap-1">
                    Bull. Trimestriels <i class="fi fi-rr-angle-small-down"></i>
                </a>
                <div class="absolute top-full left-0 pt-4 w-48 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="bg-white border border-gray-100 shadow-xl rounded-xl">
                        <?php if(!empty($newsletters)): foreach ($newsletters as $year => $months): ?>
                            <div class="group/year relative">
                                <a href="#" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50 flex justify-between items-center">
                                    Année <?= htmlspecialchars($year) ?>
                                    <i class="fi fi-rr-angle-small-right text-[10px]"></i>
                                </a>
                                <div class="absolute left-full top-0 w-40 opacity-0 invisible group-hover/year:opacity-100 group-hover/year:visible transition-all duration-300 pl-1">
                                    <div class="bg-white border border-gray-100 shadow-xl rounded-xl overflow-hidden">
                                        <?php foreach ($months as $month => $pdf): ?>
                                            <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" download class="block px-4 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-[#ea750fff] font-bold capitalize border-b border-gray-50">
                                                <?= htmlspecialchars($month) ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; else: ?>
                            <div class="p-4 text-xs text-gray-400">Aucun bulletin</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="relative group">
                <a href="#" class="hover:text-[#ea750fff] transition whitespace-nowrap flex items-center gap-1">
                    Rapp. Annuels <i class="fi fi-rr-angle-small-down"></i>
                </a>
                <div class="absolute top-full left-0 pt-4 w-40 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="bg-white border border-gray-100 shadow-xl rounded-xl">
                        <?php if(!empty($rapports)): foreach ($rapports as $year => $pdf): ?>
                            <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" download class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50 flex justify-between items-center group/item">
                                Année <?= htmlspecialchars($year) ?>
                                <i class="fi fi-rr-download text-[10px] opacity-0 group-hover/item:opacity-100 transition-opacity"></i>
                            </a>
                        <?php endforeach; else: ?>
                            <div class="p-4 text-xs text-gray-400">Aucun rapport</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="relative group">
                <a href="#" class="hover:text-[#ea750fff] transition whitespace-nowrap flex items-center gap-1">
                    Nos antennes <i class="fi fi-rr-angle-small-down"></i>
                </a>
                <div class="absolute top-full left-0 pt-4 w-40 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                    <div class="bg-white border border-gray-100 shadow-xl rounded-xl overflow-hidden">
                        <?php if(!empty($antennes_list)): foreach ($antennes_list as $antenne_nom): ?>
                            <a href="/antenne.php?nom=<?= urlencode($antenne_nom) ?>" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50 flex justify-between items-center group/item">
                                <?= htmlspecialchars($antenne_nom) ?>
                                <i class="fi fi-rr-angle-small-right text-[10px] opacity-0 group-hover/item:opacity-100 transition-opacity"></i>
                            </a>
                        <?php endforeach; else: ?>
                            <div class="p-4 text-xs text-gray-400">Aucune antenne</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="relative ml-4 group">
                <form action="recherche.php" method="GET" class="relative flex items-center">
                    <input
                        type="text"
                        name="q"
                        placeholder="RECHERCHER..."
                        class="bg-gray-100 text-[#0f277e] text-[11px] font-bold px-4 py-2 pr-10 rounded-full border border-transparent focus:border-[#44aca0] focus:bg-white focus:outline-none transition-all w-40 focus:w-56">
                    <button type="submit" class="absolute right-3 text-gray-400 group-hover:text-[#44aca0] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

        <div class="flex items-center space-x-4 lg:hidden">
            <div class="relative flex items-center">
                <form action="recherche.php" method="GET" class="flex items-center">
                    <input
                        type="text"
                        name="q"
                        placeholder="RECHERCHER..."
                        class="bg-gray-100 text-[#0f277e] text-[10px] font-bold px-3 py-2 pr-8 rounded-full border border-transparent focus:border-[#44aca0] focus:bg-white focus:outline-none transition-all w-32 focus:w-44">
                    <button type="submit" class="absolute right-2.5 text-[#0f277e] opacity-70">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>

            <button id="mobile-menu-button" class="text-[#0f277e] focus:outline-none shrink-0">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="hamburger-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </div>

    <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-gray-100 shadow-xl overflow-y-auto max-h-screen">
        <div class="px-6 py-4 flex flex-col space-y-0 font-bold uppercase text-sm tracking-wide">

            <a href="/a-propos/" class="py-1 border-b border-gray-50 text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center group">
                A propos
            </a>

            <a href="/projets/" class="py-1 border-b border-gray-50 text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center group">
                Nos projets
            </a>

            <a href="/old/pages/missions.php" class="py-1 border-b border-gray-50 text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center group">
                Nos missions
            </a>

            <details class="group/mob py-1 border-b border-gray-50">
                <summary class="text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                    Nos événements
                    <i class="fi fi-rr-angle-small-down group-open/mob:rotate-180 transition-transform"></i>
                </summary>
                <div class="pl-4 mt-2 space-y-1 mb-2 border-l-2 border-gray-100">
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest pt-2 pb-1">Festivals</div>
                    <a href="/old/pages/festival_alimenterre.php" class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2">Festival Alimenterre</a>
                    <a href="/old/pages/festival_solidarite.php" class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2">Festival des Solidarités</a>
                    <div class="text-[10px] font-black text-gray-400 uppercase tracking-widest pt-4 pb-1 border-t border-gray-50 mt-2">Journées Int.</div>
                    <a href="/old/pages/jide.php" class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2">Droits des Enfants</a>
                    <a href="/old/pages/jiv.php" class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2">Volontariat</a>
                    <a href="/old/pages/jvf.php" class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2">Journée du Volontatriat Français</a>
                </div>
            </details>

            <a href="/old/actualite/toutes_les_actualites.php" class="py-1 border-b border-gray-50 text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center group">
                Nos actions
            </a>

            <details class="group/mob py-1 border-b border-gray-50">
                <summary class="text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                    Bull. Trimestriels
                    <i class="fi fi-rr-angle-small-down group-open/mob:rotate-180 transition-transform"></i>
                </summary>
                <div class="pl-4 mt-2 space-y-1 mb-2">
                    <?php if(!empty($newsletters)): foreach ($newsletters as $year => $months): ?>
                        <details class="group/mobyear">
                            <summary class="text-gray-600 text-xs hover:text-[#ea750fff] transition-colors flex justify-between items-center cursor-pointer list-none [&::-webkit-details-marker]:hidden py-2">
                                Année <?= htmlspecialchars($year) ?>
                                <i class="fi fi-rr-angle-small-down group-open/mobyear:rotate-180 transition-transform"></i>
                            </summary>
                            <div class="pl-4 mt-1 space-y-1 mb-2 border-l-2 border-gray-100">
                                <?php foreach ($months as $month => $pdf): ?>
                                    <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" download class="block text-gray-500 text-[11px] hover:text-[#ea750fff] capitalize py-2 pl-2">
                                        <?= htmlspecialchars($month) ?>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        </details>
                    <?php endforeach; else: ?>
                        <div class="text-xs text-gray-400 py-2">Aucun bulletin</div>
                    <?php endif; ?>
                </div>
            </details>

            <details class="group/mob py-1 border-b border-gray-50">
                <summary class="text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                    Rapp. Annuels
                    <i class="fi fi-rr-angle-small-down group-open/mob:rotate-180 transition-transform"></i>
                </summary>
                <div class="pl-4 mt-2 space-y-1 mb-2 border-l-2 border-gray-100">
                    <?php if(!empty($rapports)): foreach ($rapports as $year => $pdf): ?>
                        <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" download class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2 flex justify-between items-center">
                            Année <?= htmlspecialchars($year) ?>
                            <i class="fi fi-rr-download text-[10px]"></i>
                        </a>
                    <?php endforeach; else: ?>
                        <div class="text-xs text-gray-400 py-2">Aucun rapport</div>
                    <?php endif; ?>
                </div>
            </details>

            <details class="group/mob py-1 border-b border-gray-50">
                <summary class="text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                    Nos antennes
                    <i class="fi fi-rr-angle-small-down group-open/mob:rotate-180 transition-transform"></i>
                </summary>
                <div class="pl-4 mt-2 space-y-1 mb-2 border-l-2 border-gray-100">
                    <?php if(!empty($antennes_list)): foreach ($antennes_list as $antenne_nom): ?>
                        <a href="/antenne.php?nom=<?= urlencode($antenne_nom) ?>" class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2 flex justify-between items-center">
                            <?= htmlspecialchars($antenne_nom) ?>
                            <i class="fi fi-rr-angle-small-right text-[10px]"></i>
                        </a>
                    <?php endforeach; else: ?>
                        <div class="text-xs text-gray-400 py-2">Aucune antenne</div>
                    <?php endif; ?>
                </div>
            </details>

        </div>

        <div class="bg-gray-50 p-6 text-center">
            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-[0.2em]">
                Sterna Africa &copy; 2026
            </p>
        </div>
    </div>
</nav>

<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>