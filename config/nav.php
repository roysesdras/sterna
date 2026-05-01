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

$newsletters_dir = $_SERVER['DOCUMENT_ROOT'] . '/newsletters';
$newsletters = [];
if (is_dir($newsletters_dir)) {
    $years = array_diff(scandir($newsletters_dir), ['..', '.']);
    usort($years, function($a, $b) {
        $yearA = (int)str_replace('annee_', '', $a);
        $yearB = (int)str_replace('annee_', '', $b);
        return $yearB <=> $yearA; // Tri décroissant numérique
    });
    foreach ($years as $year_dir) {
        if (is_dir($newsletters_dir . '/' . $year_dir)) {
            $year_label = str_replace('annee_', '', $year_dir);
            $months = array_diff(scandir($newsletters_dir . '/' . $year_dir), ['..', '.']);
            $newsletters[$year_label] = [];
            foreach ($months as $month_dir) {
                if (is_dir($newsletters_dir . '/' . $year_dir . '/' . $month_dir)) {
                    $files = glob($newsletters_dir . '/' . $year_dir . '/' . $month_dir . '/*.{pdf,PDF}', GLOB_BRACE);
                    if (!empty($files)) {
                        $pdf_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $files[0]);
                        $newsletters[$year_label][$month_dir] = $pdf_path;
                    }
                }
            }
        }
    }
}

$rapports_dir = $_SERVER['DOCUMENT_ROOT'] . '/rapport';
$rapports = [];
if (is_dir($rapports_dir)) {
    $years_r = array_diff(scandir($rapports_dir), ['..', '.']);
    usort($years_r, function($a, $b) {
        $yearA = (int)str_replace('annee_', '', $a);
        $yearB = (int)str_replace('annee_', '', $b);
        return $yearB <=> $yearA; // Tri décroissant numérique
    }); 
    foreach ($years_r as $year_dir) {
        if (is_dir($rapports_dir . '/' . $year_dir)) {
            $year_label = str_replace('annee_', '', $year_dir);
            $files = glob($rapports_dir . '/' . $year_dir . '/*.{pdf,PDF}', GLOB_BRACE);
            if (!empty($files)) {
                $pdf_path = str_replace($_SERVER['DOCUMENT_ROOT'], '', $files[0]);
                $rapports[$year_label] = $pdf_path;
            }
        }
    }
}
?>
<nav class="bg-gray-100 shadow-md sticky top-0 z-50 text-gray-700">
    <div class="max-w-7xl mx-auto px-2 flex justify-between items-center h-20">

        <div class="flex items-center shrink-0 cursor-pointer group">
            <div class="transition-transform group-hover:scale-105 duration-300">
                <a href="/"><img src="https://i.postimg.cc/ZqS0t5js/sternaofficiel-2.png" alt="Logo sterna africa" class="h-16 md:h-16 w-auto object-contain"></a>
            </div>
        </div>

        <div class="hidden lg:flex space-x-6 font-bold text-[14px] uppercase items-center">
            <a href="#about" class="hover:text-[#ea750fff] transition whitespace-nowrap">Qui sommes-nous ?</a>
            <a href="#secteurs" class="hover:text-[#ea750fff] transition whitespace-nowrap">Nos missions</a>

            <a href="./actualite/toutes_les_actualites.php" class="hover:text-[#ea750fff] transition whitespace-nowrap">Nos actions</a>

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
                                            <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" class="block px-4 py-3 text-[11px] text-gray-600 hover:bg-gray-50 hover:text-[#ea750fff] font-bold capitalize border-b border-gray-50">
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
                            <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" class="block px-4 py-3 text-xs text-gray-700 hover:bg-gray-50 hover:text-[#ea750fff] font-bold border-b border-gray-50 flex justify-between items-center group/item">
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

            <a href="#about" class="py-1 border-b border-gray-50 text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center group">
                Qui sommes-nous ?
            </a>

            <a href="#" class="py-1 border-b border-gray-50 text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center group">
                Nos missions
            </a>

            <a href="./actualite/toutes_les_actualites.php" class="py-1 border-b border-gray-50 text-gray-700 hover:text-[#ea750fff] transition-colors flex justify-between items-center group">
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
                                    <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" class="block text-gray-500 text-[11px] hover:text-[#ea750fff] capitalize py-2 pl-2">
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
                        <a href="<?= htmlspecialchars($pdf) ?>" target="_blank" class="block text-gray-600 text-xs hover:text-[#ea750fff] py-2 pl-2 flex justify-between items-center">
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
                Urunani Afrique &copy; 2026
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