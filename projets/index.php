<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Récupération de TOUS les projets
$projets = [];
$result_projets = $conn->query("SELECT nom, slug, description, image_main FROM projets ORDER BY nom ASC");
if ($result_projets) {
    while ($row_p = $result_projets->fetch_assoc()) {
        $projets[] = $row_p;
    }
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- En-tête -->
    <header class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <!-- Image de fond floutée et assombrie -->
            <img src="https://sternaafrica.org/images/garde.jpg" alt="Fond Sterna" class="w-full h-full object-cover opacity-20 scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-sterna-blue to-transparent"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Nos Actions</span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 tracking-tight leading-tight">
                Tous Nos <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-sterna-yellow">Projets</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto font-medium leading-relaxed">
                Découvrez l'ensemble de nos actions de solidarité, d'éducation et de développement sur le terrain.
            </p>
        </div>
    </header>

    <main class="relative z-20 container mx-auto px-4 -mt-10 mb-24">
        
        <?php if (!empty($projets)): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <?php foreach($projets as $projet): ?>
                <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col justify-between items-start h-full group relative overflow-hidden">
                    
                    <?php if (!empty($projet['image_main'])): ?>
                        <!-- Image de fond optionnelle pour un rendu plus beau -->
                        <div class="absolute inset-0 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                            <img src="/images/projets/<?php echo htmlspecialchars($projet['image_main']); ?>" class="w-full h-full object-cover">
                        </div>
                    <?php endif; ?>

                    <div class="relative z-10 w-full">
                        <?php if (!empty($projet['image_main'])): ?>
                            <div class="w-full h-40 bg-gray-100 rounded-xl overflow-hidden mb-6 group-hover:shadow-md transition-shadow">
                                <img src="/images/projets/<?php echo htmlspecialchars($projet['image_main']); ?>" alt="<?php echo htmlspecialchars($projet['nom']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        <?php else: ?>
                            <div class="w-12 h-12 bg-blue-50 text-sterna-blue rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-sterna-blue group-hover:text-white transition-all duration-300">
                                <i class="fi fi-rr-rocket text-xl"></i>
                            </div>
                        <?php endif; ?>
                        
                        <h3 class="text-2xl font-black text-gray-900 mb-3"><?php echo htmlspecialchars($projet['nom']); ?></h3>
                        <p class="text-gray-500 mb-6 line-clamp-3">
                            <?php 
                                if (!empty($projet['description'])) {
                                    echo nl2br(htmlspecialchars($projet['description']));
                                } else {
                                    echo "Découvrez les actions de solidarité, l'impact éducatif et toutes les activités menées dans le cadre de ce projet.";
                                }
                            ?>
                        </p>
                    </div>
                    <a href="/projet/<?php echo urlencode($projet['slug']); ?>" class="relative z-10 inline-flex items-center gap-2 text-sterna-blue font-bold group-hover:text-sterna-yellow transition-colors mt-auto">
                        Voir plus <i class="fi fi-rr-arrow-small-right mt-1 text-lg"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="text-center py-24 bg-white rounded-3xl shadow-xl">
            <h3 class="text-2xl text-gray-500 font-bold mb-4">Aucun projet n'est disponible pour le moment.</h3>
            <p class="text-gray-400">Revenez très bientôt pour découvrir nos nouvelles actions.</p>
        </div>
        <?php endif; ?>

    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>
