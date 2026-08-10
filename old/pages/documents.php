<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php'; 

// Fetch Bulletins grouped by year
$page_bulletins = [];
if (isset($conn)) {
    $res_bull = $conn->query("SELECT * FROM rapports WHERE type_document = 'bulletin' ORDER BY annee DESC, trimestre DESC");
    if ($res_bull && $res_bull->num_rows > 0) {
        while ($row = $res_bull->fetch_assoc()) {
            $year = $row['annee'];
            if (!isset($page_bulletins[$year])) {
                $page_bulletins[$year] = [];
            }
            $page_bulletins[$year][] = $row;
        }
    }
}

// Fetch Rapports Annuels grouped by year
$page_rapports = [];
if (isset($conn)) {
    $res_rap = $conn->query("SELECT * FROM rapports WHERE type_document = 'rapport_annuel' ORDER BY annee DESC");
    if ($res_rap && $res_rap->num_rows > 0) {
        while ($row = $res_rap->fetch_assoc()) {
            $year = $row['annee'];
            if (!isset($page_rapports[$year])) {
                $page_rapports[$year] = [];
            }
            $page_rapports[$year][] = $row;
        }
    }
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <header class="relative pt-10 pb-10 md:pt-20 md:pb-14 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-b from-sterna-blue to-transparent opacity-90 z-10"></div>
        </div>
        <div class="container mx-auto px-6 relative z-20 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Bibliothèque</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Nos <span class="text-sterna-yellow">Documents</span></h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Retrouvez nos bulletins trimestriels et rapports annuels en téléchargement libre.</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-16 -mt-10 relative z-30 mb-20">
        <div class="rounded-[2rem] p-2 md:p-6">
            
            <!-- Tabs Navigation -->
            <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                <button id="btn-bulletins" onclick="switchTab('bulletins')" class="px-8 py-4 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-sterna-blue text-white shadow-lg shadow-sterna-blue/30 scale-105">
                    Bulletins Trimestriels
                </button>
                <button id="btn-rapports" onclick="switchTab('rapports')" class="px-6 py-4 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200">
                    Rapports Annuels
                </button>
            </div>

            <!-- Bulletins Section -->
            <div id="tab-bulletins" class="space-y-16 fade-in">
                <?php if (!empty($page_bulletins)): foreach ($page_bulletins as $year => $docs): ?>
                    <div>
                        <div class="flex items-center gap-4 mb-8">
                            <h2 class="text-3xl font-black text-sterna-blue">Année <?= htmlspecialchars($year) ?></h2>
                            <div class="h-1 flex-grow bg-gradient-to-r from-sterna-blue/20 to-transparent rounded-full"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <?php foreach ($docs as $doc): ?>
                                <div class="bg-gray-50 rounded-2xl shadow hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-gray-200">
                                    <div class="relative h-40 overflow-hidden bg-white flex items-center justify-center">
                                        <?php if (!empty($doc['cover_image'])): ?>
                                            <img src="<?= htmlspecialchars($doc['cover_image']) ?>" alt="<?= htmlspecialchars($doc['titre']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <?php else: ?>
                                            <i class="fi fi-rr-document text-4xl text-gray-300"></i>
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        <span class="absolute top-3 right-3 bg-sterna-yellow text-sterna-blue text-[10px] font-bold px-2 py-1 rounded shadow-sm">
                                            <?= !empty($doc['trimestre']) ? htmlspecialchars($doc['trimestre']) : 'T1' ?>
                                        </span>
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 text-sm"><?= htmlspecialchars($doc['titre']) ?></h3>
                                        <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-200">
                                            <span class="text-[10px] text-gray-500 font-medium"><?= date('d/m/Y', strtotime($doc['created_at'])) ?></span>
                                            <a href="<?= htmlspecialchars($doc['pdf_link']) ?>" download class="w-8 h-8 rounded-full bg-sterna-blue flex items-center justify-center text-white hover:bg-sterna-yellow hover:text-sterna-blue transition-colors shadow-sm" title="Télécharger">
                                                <i class="fi fi-rr-download text-xs mt-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="text-center text-gray-500 py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">Aucun bulletin trimestriel disponible pour le moment.</div>
                <?php endif; ?>
            </div>

            <!-- Rapports Section -->
            <div id="tab-rapports" class="hidden space-y-16 fade-in">
                <?php if (!empty($page_rapports)): foreach ($page_rapports as $year => $docs): ?>
                    <div>
                        <div class="flex items-center gap-4 mb-8">
                            <h2 class="text-3xl font-black text-[#ea750fff]">Année <?= htmlspecialchars($year) ?></h2>
                            <div class="h-1 flex-grow bg-gradient-to-r from-[#ea750fff]/20 to-transparent rounded-full"></div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <?php foreach ($docs as $doc): ?>
                                <div class="bg-gray-50 rounded-2xl shadow hover:shadow-xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-gray-200 hover:border-[#ea750fff]/50">
                                    <div class="relative h-40 overflow-hidden bg-white flex items-center justify-center">
                                        <?php if (!empty($doc['cover_image'])): ?>
                                            <img src="<?= htmlspecialchars($doc['cover_image']) ?>" alt="<?= htmlspecialchars($doc['titre']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        <?php else: ?>
                                            <i class="fi fi-rr-document text-4xl text-gray-300"></i>
                                        <?php endif; ?>
                                        <div class="absolute inset-0 bg-gradient-to-t from-gray-900/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    </div>
                                    <div class="p-5 flex flex-col flex-grow">
                                        <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 text-sm group-hover:text-[#ea750fff] transition-colors"><?= htmlspecialchars($doc['titre']) ?></h3>
                                        <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-200">
                                            <span class="text-[10px] text-gray-500 font-medium"><?= date('d/m/Y', strtotime($doc['created_at'])) ?></span>
                                            <a href="<?= htmlspecialchars($doc['pdf_link']) ?>" download class="w-8 h-8 rounded-full bg-[#ea750fff] flex items-center justify-center text-white hover:bg-sterna-blue transition-colors shadow-sm" title="Télécharger">
                                                <i class="fi fi-rr-download text-xs mt-1"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="text-center text-gray-500 py-10 bg-gray-50 rounded-2xl border border-dashed border-gray-300">Aucun rapport annuel disponible pour le moment.</div>
                <?php endif; ?>
            </div>

        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>

    <style>
        .fade-in { animation: fadeIn 0.4s ease-in-out forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    <script>
        function switchTab(tabName) {
            const btnBull = document.getElementById('btn-bulletins');
            const btnRap = document.getElementById('btn-rapports');
            const tabBull = document.getElementById('tab-bulletins');
            const tabRap = document.getElementById('tab-rapports');

            if (tabName === 'bulletins') {
                tabBull.classList.remove('hidden');
                tabRap.classList.add('hidden');
                
                btnBull.className = "px-8 py-4 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-sterna-blue text-white shadow-lg shadow-sterna-blue/30 scale-105";
                btnRap.className = "px-8 py-4 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200 scale-100";
            } else {
                tabRap.classList.remove('hidden');
                tabBull.classList.add('hidden');
                
                btnRap.className = "px-8 py-4 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-sterna-blue text-white shadow-lg shadow-sterna-blue/30 scale-105";
                btnBull.className = "px-8 py-4 rounded-full font-bold text-sm md:text-base transition-all duration-300 bg-gray-100 text-gray-600 hover:bg-gray-200 scale-100";
            }
        }
    </script>
</body>
</html>
