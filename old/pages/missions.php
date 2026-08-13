<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/db.php';
$recent_docs = [];
if (isset($conn)) {
    $res_docs = $conn->query("SELECT * FROM rapports ORDER BY created_at DESC LIMIT 4");
    if ($res_docs && $res_docs->num_rows > 0) {
        while ($row = $res_docs->fetch_assoc()) {
            $recent_docs[] = $row;
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
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Ce que nous faisons</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Nos <span class="text-sterna-yellow">Missions</span></h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">S'engager pour le développement et la solidarité internationale.</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-16 -mt-10 relative z-30 mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Colonne Texte -->
            <div class="lg:col-span-7 bg-white p-8 md:p-12 rounded-3xl shadow-xl">
                <h2 class="text-3xl font-black text-sterna-blue mb-6">Un engagement profond</h2>
                <p class="text-lg leading-relaxed mb-4 font-medium text-gray-700">
                    Notre mission est d'œuvrer pour un monde durable et juste en contribuant activement à l'atteinte des ODD. Pour ce faire, nous intervenons dans plusieurs domaines clés tels que les relations Nord-Sud, le volontariat et le développement communautaire, tout en plaçant toujours la communauté au cœur de nos actions.
                </p>
                <!-- Vous pouvez ajouter la suite de votre texte ici -->
                <p class="text-lg leading-relaxed mb-4 text-gray-600">
                    Toutes nos initiatives s'adressent en particulier aux enfants, aux femmes, à la jeunesse et à la préservation de l'environnement.
                </p>
                <p class="text-lg leading-relaxed mb-4 text-gray-600">
                    Découvrez les quatre piliers de nos actions sur le terrain :
                </p>

                <ul class="space-y-4 text-lg text-gray-600 leading-relaxed mb-4">
                    <li>
                        <span class="font-bold text-sterna-yellow">Les Enfants :</span>  Éveiller, éduquer et accompagner la jeunesse rurale à travers des programmes phares comme Educ'Moi, Vacances Fun et la célébration de la Journée mondiale des droits de l'enfant pour leur offrir de belles perspectives d'avenir. <br>
                        <span class="font-bold text-sterna-blue">Clic sur la carte pour en savoir plus.</span>
                    </li>
                    <li>
                        <span class="font-bold text-sterna-yellow">Les Femmes :</span> Autonomiser et protéger les femmes rurales en agissant concrètement sur leur santé et leur bien-être via le projet Sang Tabou, les ateliers d'hygiène alimentaire et menstruelle, ainsi que les formations aux premiers secours.
                        <br>
                        <span class="font-bold text-sterna-blue">Clic sur la carte pour en savoir plus.</span>
                    </li>
                    <li>
                        <span class="font-bold text-sterna-yellow">La Jeunesse :</span> Créer de véritables ponts interculturels et solidaires grâce au Camp ECSI, aux Chantiers de Solidarité Internationale (CSI) et aux chantiers de réfection communautaires menés main dans la main entre jeunes et seniors.
                        <br>
                        <span class="font-bold text-sterna-blue">Clic sur la carte pour en savoir plus.</span>
                    </li>
                    <li>
                        <span class="font-bold text-sterna-yellow">L'Environnement :</span> Lutter contre le réchauffement climatique et préserver notre cadre de vie à travers des actions concrètes comme le projet Tri'Pop, la protection des écosystèmes et des espèces marines, et nos grandes campagnes de reboisement.
                        <br>
                        <span class="font-bold text-sterna-blue">Clic sur la carte pour en savoir plus.</span>
                    </li>
                </ul>
            </div>

            <!-- Colonne Cartes (Sticky) -->
            <div class="lg:col-span-5 relative">
                <h1 class="text-3xl font-black text-sterna-yellow mb-6">Nos Cibles</h1>
                <div class="sticky top-24 grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">

                    <a href="/old/pages/enfant.php">
                        <div class="p-6 rounded-[35px] shadow-xl hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group bg-white h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-purple-50 flex items-center justify-center text-sterna-blue text-2xl mb-4 group-hover:bg-sterna-blue group-hover:text-white transition-all">
                                <i class="fi fi-rr-user"></i>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 uppercase mb-2">Enfants</h3>
                            <p class="text-gray-500 text-xs leading-relaxed font-medium">Éducation inclusive et bien-être.</p>
                        </div>
                    </a>

                    <a href="/old/pages/femmes.php">
                        <div class="p-6 rounded-[35px] shadow-xl hover:shadow-2xl hover:shadow-orange-100 transition-all duration-500 group bg-sterna-blue h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-sterna-yellow text-2xl mb-4 group-hover:bg-sterna-yellow group-hover:text-white transition-all">
                                <i class="fi fi-rr-venus"></i>
                            </div>
                            <h3 class="text-lg font-black text-white uppercase mb-2">Femmes</h3>
                            <p class="text-gray-100 text-xs leading-relaxed font-medium">Autonomie et défense des droits.</p>
                        </div>
                    </a>

                    <a href="/old/pages/jeunesse.php">
                        <div class="p-6 rounded-[35px] shadow-xl hover:shadow-2xl hover:shadow-teal-100 transition-all duration-500 group bg-sterna-yellow h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-white/30 flex items-center justify-center text-gray-900 text-2xl mb-4 group-hover:bg-sterna-blue group-hover:text-white transition-all">
                                <i class="fi fi-rr-users"></i>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 uppercase mb-2">Jeunesse</h3>
                            <p class="text-gray-700 text-xs leading-relaxed font-medium">Inclusion et engagement citoyen.</p>
                        </div>
                    </a>

                    <a href="/old/pages/environnement.php">
                        <div class="p-6 rounded-[35px] shadow-xl hover:shadow-2xl hover:shadow-green-100 transition-all duration-500 group bg-white h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-600 text-2xl mb-4 group-hover:bg-sterna-yellow group-hover:text-white transition-all">
                                <i class="fi fi-rr-leaf"></i>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 uppercase mb-2">Environnement</h3>
                            <p class="text-gray-500 text-xs leading-relaxed font-medium">Protection des écosystèmes.</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </main>

    <section class="bg-sterna-yellow py-20 relative z-30">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block py-1 px-3 rounded-full bg-white text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4 shadow-sm">Ce qui nous anime</span>
                <h2 class="text-4xl font-black text-sterna-blue">Nos <span class="text-white">Valeurs</span></h2>
                <p class="text-lg text-gray-800 mt-4 max-w-2xl mx-auto font-medium">L'éthique et la responsabilité guident nos pas au quotidien. Découvrez les quatre convictions profondes de Sterna Africa.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-8 rounded-[35px] shadow-xl hover:shadow-2xl transition-all duration-500 group bg-white h-full flex flex-col items-center text-center hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-pink-50 flex items-center justify-center text-pink-500 text-3xl mb-6 group-hover:bg-pink-500 group-hover:text-white transition-all">
                        <i class="fi fi-rr-heart"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase mb-3">Solidarité International</h3>
                    <p class="text-gray-600 text-sm leading-relaxed font-medium">L'entraide et le soutien mutuel sont au cœur de toutes nos actions pour les communautés vulnérables.</p>
                </div>

                <div class="p-8 rounded-[35px] shadow-xl hover:shadow-2xl transition-all duration-500 group bg-white h-full flex flex-col items-center text-center hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-sterna-blue text-3xl mb-6 group-hover:bg-sterna-blue group-hover:text-white transition-all">
                        <i class="fi fi-rr-eye"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase mb-3">Éducation Populaire</h3>
                    <p class="text-gray-600 text-sm leading-relaxed font-medium">Ateliers de formation citoyenne (masterclass, modules thématiques), Ciné-débats et cafés-débats, Ateliers ludo-pédagogiques</p>
                </div>

                <div class="p-8 rounded-[35px] shadow-xl hover:shadow-2xl transition-all duration-500 group bg-white h-full flex flex-col items-center text-center hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 text-3xl mb-6 group-hover:bg-orange-500 group-hover:text-white transition-all">
                        <i class="fi fi-rr-hands-heart"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase mb-3">Volontariat</h3>
                    <p class="text-gray-600 text-sm leading-relaxed font-medium">Recrutement, formation et accompagnement de volontaires Programmes de volontariat national ou international (VSI, service civique, etc.)</p>
                </div>

                <div class="p-8 rounded-[35px] shadow-xl hover:shadow-2xl transition-all duration-500 group bg-white h-full flex flex-col items-center text-center hover:-translate-y-2">
                    <div class="w-16 h-16 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 text-3xl mb-6 group-hover:bg-teal-600 group-hover:text-white transition-all">
                        <i class="fi fi-rr-scale"></i>
                    </div>
                    <h3 class="text-xl font-black text-gray-900 uppercase mb-3">Développement Communautaire</h3>
                    <p class="text-gray-600 text-sm leading-relaxed font-medium">Appui à des projets communautaires locaux (eau, santé, éducation,infrastructures)</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-gray-50 py-20 relative z-30">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow/20 text-sterna-yellow text-xs font-bold uppercase tracking-widest mb-4 shadow-sm border border-sterna-yellow/30">Publications</span>
                <h2 class="text-4xl font-black text-gray-900">Nos <span class="text-sterna-blue">Documents</span></h2>
                <p class="text-lg text-gray-600 mt-4 max-w-2xl mx-auto font-medium">Consultez nos bulletins trimestriels et nos rapports annuels pour suivre l'évolution de nos projets.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <?php if (!empty($recent_docs)): foreach ($recent_docs as $doc): ?>
                    <div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition-all duration-300 overflow-hidden group flex flex-col h-full border border-gray-100">
                        <div class="relative h-48 overflow-hidden bg-gray-100 flex items-center justify-center">
                            <?php if (!empty($doc['cover_image'])): ?>
                                <img src="<?= htmlspecialchars($doc['cover_image']) ?>" alt="<?= htmlspecialchars($doc['titre']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            <?php else: ?>
                                <i class="fi fi-rr-document text-5xl text-gray-300 mt-4"></i>
                            <?php endif; ?>
                            <div class="absolute inset-0 bg-gradient-to-t from-gray-900/80 to-transparent opacity-60"></div>
                            <span class="absolute top-4 left-4 bg-white/90 backdrop-blur text-sterna-blue text-[10px] font-bold px-3 py-1 rounded-full uppercase shadow-sm">
                                <?= $doc['type_document'] === 'bulletin' ? 'Bulletin' : 'Rapport' ?> <?= htmlspecialchars($doc['annee']) ?>
                            </span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-bold text-gray-900 mb-2 line-clamp-2 leading-tight"><?= htmlspecialchars($doc['titre']) ?></h3>
                            <div class="mt-auto pt-4 flex justify-between items-center border-t border-gray-50">
                                <span class="text-xs text-gray-500 font-medium"><i class="fi fi-rr-calendar-lines mr-1 text-[#ea750fff]"></i> <?= date('d M Y', strtotime($doc['created_at'])) ?></span>
                                <a href="<?= htmlspecialchars($doc['pdf_link']) ?>" download class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center text-sterna-blue hover:bg-sterna-blue hover:text-white transition-all shadow-sm group/btn" title="Télécharger">
                                    <i class="fi fi-rr-download text-sm mt-1 group-hover/btn:translate-y-0.5 transition-transform"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; else: ?>
                    <div class="col-span-full text-center text-gray-500 py-10 bg-white rounded-3xl border border-gray-100 shadow-sm">Aucun document récent disponible.</div>
                <?php endif; ?>
            </div>

            <div class="text-center">
                <a href="/old/pages/documents.php" class="inline-flex items-center justify-center px-8 py-4 bg-sterna-blue text-white font-bold rounded-full hover:bg-sterna-yellow hover:text-gray-900 transition-colors duration-300 shadow-lg hover:shadow-xl group">
                    Voir tous nos documents <i class="fi fi-rr-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                </a>
            </div>
        </div>
    </section>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>
