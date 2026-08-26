<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';

// Récupération dynamique du nombre d'abonnés comme dans impact.php
$abonnes_count = 0;
$result = $conn->query("SELECT COUNT(*) as count FROM abonnes");
if ($result) {
    $row = $result->fetch_assoc();
    $abonnes_count = (int)$row['count'];
}
$total_abonnes = 1500 + $abonnes_count;

// Récupération dynamique du nombre d'antennes (Pays d'intervention)
$antennes_count = 0;
$result_ant = $conn->query("SELECT COUNT(*) as count FROM antennes");
if ($result_ant) {
    $row_ant = $result_ant->fetch_assoc();
    $antennes_count = (int)$row_ant['count'];
}

// Récupération des projets pour la section "Nos Projets"
$projets = [];
$total_projets = 0;

// Compter le nombre total de projets
$result_count_projets = $conn->query("SELECT COUNT(*) as count FROM projets");
if ($result_count_projets) {
    $row_count = $result_count_projets->fetch_assoc();
    $total_projets = (int)$row_count['count'];
}

$result_projets = $conn->query("SELECT nom, slug, description, image_main FROM projets ORDER BY nom ASC LIMIT 6");
if ($result_projets) {
    while ($row_p = $result_projets->fetch_assoc()) {
        $projets[] = $row_p;
    }
}
?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- En-tête / Hero Section -->
    <header class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <!-- Image de fond floutée et assombrie -->
            <img loading="lazy" decoding="async" src="https://sternaafrica.org/images/garde.jpg" alt="Fond Sterna" class="w-full h-full object-cover opacity-20 scale-105">
            <div class="absolute inset-0 bg-gradient-to-t from-sterna-blue to-transparent"></div>
        </div>
        <div class="container mx-auto px-6 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">À Propos</span>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-white mb-6 tracking-tight leading-tight">
                Sterna Africa <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-300 to-sterna-yellow">International</span>
            </h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto font-medium leading-relaxed">
                Une associations d'ECSI composer de jeunes de solidarité internationale, présent partout où le besoin se fait sentir.
            </p>
        </div>
    </header>

    <main class="relative -mt-8 z-20">
        <!-- Chiffres & Impact (Stats Grid) -->
        <section class="container mx-auto px-4 mb-6 md:mb-20">
            <div class="bg-gray-100 rounded-3xl shadow-xl p-8 md:p-12 border border-gray-100">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-black text-sterna-blue mb-2"><strong>Notre Impact</strong></h2>
                    <div class="w-24 h-1 bg-sterna-yellow mx-auto rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 text-center">
                    <div class="p-2">
                        <div class="text-3xl md:text-4xl font-black text-sterna-blue mb-2">99 552</div>
                        <div class="text-gray-500 font-bold uppercase tracking-wider text-[10px] md:text-xs">Bénéficiaires<br>Directs & Indirects</div>
                    </div>
                    <div class="p-2">
                        <div class="text-3xl md:text-4xl font-black text-sterna-yellow mb-2"><?php echo number_format($total_abonnes, 0, ',', ' '); ?></div>
                        <div class="text-gray-500 font-bold uppercase tracking-wider text-[10px] md:text-xs">Nombre<br>d'abonnés</div>
                    </div>
                    <div class="p-2">
                        <div class="text-3xl md:text-4xl font-black text-emerald-500 mb-2">1 539</div>
                        <div class="text-gray-500 font-bold uppercase tracking-wider text-[10px] md:text-xs">Personnes<br>formées</div>
                    </div>
                    <div class="p-2">
                        <div class="text-3xl md:text-4xl font-black text-sterna-blue mb-2">580</div>
                        <div class="text-gray-500 font-bold uppercase tracking-wider text-[10px] md:text-xs">Volontaires<br>adhérents</div>
                    </div>
                    <div class="p-2">
                        <div class="text-3xl md:text-4xl font-black text-rose-500 mb-2">213</div>
                        <div class="text-gray-500 font-bold uppercase tracking-wider text-[10px] md:text-xs">Projets &<br>Activités</div>
                    </div>
                    <div class="p-2">
                        <div class="text-3xl md:text-4xl font-black text-emerald-500 mb-2"><?php echo $antennes_count; ?></div>
                        <div class="text-gray-500 font-bold uppercase tracking-wider text-[10px] md:text-xs">Pays<br>d'intervention</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Mission & Vision -->
        <div class="container mx-auto mb-6 md:mb-20 p-4 md:p-0">
            <img loading="lazy" decoding="async" src="/assets/img/external/9af343c8df_Whats-App-Image-2026-08-13-at-11-54-14-AM.jpg" alt="" class="rounded-3xl w-full h-auto  md:h-[450px] object-contain md:object-cover shadow-lg">
        </div>

        <!-- Relation Nord-Sud -->
        <section class="container mx-auto px-4 mb-24">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">
                <div class="flex-1 space-y-6">
                    <h2 class="text-3xl md:text-4xl font-black text-sterna-blue"><strong>La Relation Nord-Sud, C'est Quoi ?</strong></h2>
                    <div class="w-24 h-1 bg-sterna-yellow rounded-full"></div>
                    
                    <p class="text-gray-600 leading-relaxed text-lg">
                        L'échange interculturel est au cœur de notre vision. La relation Nord-Sud (et Sud-Sud) que nous promouvons n'est pas à sens unique, c'est un véritable <strong>partage de compétences, de cultures et d'humanité</strong>.
                    </p>
                    <p class="text-gray-600 leading-relaxed text-lg">
                        Nous accueillons des volontaires internationaux en Afrique et accompagnons les initiatives locales pour un développement durable. C'est l'essence même de <em>l'Éducation à la Citoyenneté et à la Solidarité Internationale (ECSI)</em>.
                    </p>
                    <ul class="space-y-4 mt-6">
                        <li class="flex items-start gap-3">
                            <i class="fi fi-rr-check-circle text-sterna-yellow mt-1 text-lg"></i>
                            <span class="text-gray-700 font-medium">Échanges équitables et réciproques</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fi fi-rr-check-circle text-sterna-yellow mt-1 text-lg"></i>
                            <span class="text-gray-700 font-medium">Immersion culturelle authentique</span>
                        </li>
                        <li class="flex items-start gap-3">
                            <i class="fi fi-rr-check-circle text-sterna-yellow mt-1 text-lg"></i>
                            <span class="text-gray-700 font-medium">Impact durable sur les communautés locales</span>
                        </li>
                    </ul>
                </div>
                
                <div class="flex-1 relative">
                    <div class="absolute inset-0 bg-sterna-yellow rounded-3xl transform translate-x-4 translate-y-4"></div>
                    <img loading="lazy" decoding="async" src="/assets/img/external/c91b232b72_1755464569925.jpg" alt="Relation Nord Sud" class="relative z-10 w-full h-[400px] object-cover rounded-3xl shadow-xl">
                </div>
            </div>
        </section>

        <!-- L'Équipe -->
        <section class="bg-sterna-blue py-20">
            <div class="container mx-auto px-4 text-center mb-8">
                <h2 class="text-3xl md:text-5xl font-black text-white mb-2"><strong>L'Équipe Dirigeante</strong></h2>
                <p class="text-blue-100 max-w-2xl mx-auto text-lg">Des hommes et des femmes engagés au quotidien pour faire rayonner la solidarité internationale.</p>
            </div>
            
            <?php include __DIR__ . '/../config/bureau_inter.php'; ?>
        </section>

        <!-- Nos Projets -->
        <?php if (!empty($projets)): ?>
        <section class="bg-gray-100 py-24">
            <div class="container mx-auto px-4">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-2"><strong>Nos Projets</strong></h2>
                    <div class="w-24 h-1 bg-sterna-yellow mx-auto rounded-full mt-4"></div>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                    <?php foreach($projets as $projet): ?>
                        <div class="bg-white rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-300 border border-gray-100 flex flex-col justify-between items-start h-full group relative overflow-hidden">
                            
                            <?php if (!empty($projet['image_main'])): ?>
                                <!-- Image de fond optionnelle pour un rendu plus beau -->
                                <div class="absolute inset-0 opacity-10 group-hover:opacity-20 transition-opacity duration-300">
                                    <img loading="lazy" decoding="async" src="/images/projets/<?php echo htmlspecialchars($projet['image_main']); ?>" class="w-full h-full object-cover">
                                </div>
                            <?php endif; ?>

                            <div class="relative z-10 w-full">
                                <?php if (!empty($projet['image_main'])): ?>
                                    <div class="w-full h-40 bg-gray-100 rounded-xl overflow-hidden mb-6 group-hover:shadow-md transition-shadow">
                                        <img loading="lazy" decoding="async" src="/images/projets/<?php echo htmlspecialchars($projet['image_main']); ?>" alt="<?php echo htmlspecialchars($projet['nom']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                
                <?php if ($total_projets > 6): ?>
                <div class="mt-16 text-center">
                    <a href="/projets/" class="inline-flex items-center gap-2 bg-sterna-yellow hover:bg-yellow-400 text-sterna-blue font-bold py-4 px-10 rounded-full transition-all shadow-lg hover:shadow-xl hover:-translate-y-1 text-lg">
                        Voir tous les projets <i class="fi fi-rr-arrow-small-right mt-1 text-xl"></i>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php endif; ?>

    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>

</body>
</html>