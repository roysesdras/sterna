<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <header class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <!-- Image de fond -->
            <img src="https://i.postimg.cc/4y4pQGtk/afro1.jpg" alt="Enfants" class="w-full h-full object-cover opacity-60 mix-blend-luminosity">
            <!-- Surcouche bleue et dégradé -->
            <div class="absolute inset-0 bg-sterna-blue/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-sterna-blue via-sterna-bleu/80 to-transparent z-10"></div>
        </div>

        <div class="container mx-auto px-6 relative z-20 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Notre Public Cible</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">La <span class="text-teal-400">Jeunesse</span></h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Inclusion, formation et engagement citoyen.</p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-10 text-left text-gray-600 bg-gray-100 rounded-3xl shadow-xl -mt-10 relative z-30 mb-20">
        <div class="container mx-auto">
            <p class="text-lg leading-relaxed mb-4">
                On a souvent tendance à l'oublier, mais la jeunesse n'est pas seulement l'avenir de nos communautés : elle en est le cœur battant, ici et maintenant.
            </p>

            <p class="text-lg leading-relaxed mb-4">
                Sur le terrain, nos actions avec les jeunes ne se résument pas à encadrer des activités. C'est avant tout une aventure humaine, un brassage de cultures et une énergie brute mise au service du collectif.
            </p>

             <p class="text-lg leading-relaxed mb-4">
                Cet engagement se vit à travers des temps forts qui laissent des traces durables :
            </p>

            <ul>
                <li class="mb-4">
                    <strong>Le Camp ECSI :</strong> C'est le point de rencontre par excellence. On y brise les frontières et les clichés en réunissant des jeunes de tous horizons. Pendant ces séjours, le mot d'ordre c'est le partage brut, l'éducation populaire et l'interculturalité. On discute, on débat, on apprend des réalités des autres, et on réalise à quel point nos différences sont une force immense.
                </li>

                <li class="mb-4">
                    <strong>Le CSI (Chantier de Solidarité Internationale) :</strong> Ici, la solidarité se vit les mains dans la terre et le sourire aux lèvres. Des volontaires venus du Nord et du Sud se côtoient, vivent ensemble et unissent leurs forces. Au programme : du soutien scolaire pour donner un coup de pouce aux élèves, des animations pleines de vie avec les enfants du village, et des campagnes de sensibilisation menées par les jeunes, pour les jeunes.
                </li>

                <li class="mb-4">
                    <strong>Les chantiers de réfection communautaires :</strong> Rien ne soude plus un groupe que de bâtir ou de rénover de ses propres mains un lieu de vie pour tous. Ce qu'il y a de magique ici, c'est la mixité des âges. On retrouve côte à côte la fougue de la jeunesse et la sagesse des seniors. Ensemble, aux côtés de la communauté et pour la communauté, ils retapent un bâtiment, restaurent un espace public, et transmettent des savoir-faire dans un respect mutuel profond.
                </li>
            </ul>

            <p class="text-lg leading-relaxed mb-4 mt-6 font-medium">
                Investir dans la jeunesse, c'est créer des ponts là où certains sèment des murs.
            </p>

            <div class="relative mt-12 group/carousel">
                <!-- Bouton Précédent -->
                <button onclick="document.getElementById('carousel-enfants').scrollBy({left: -300, behavior: 'smooth'})" class="absolute left-2 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/90 backdrop-blur rounded-full shadow-xl flex items-center justify-center text-sterna-blue hover:bg-sterna-yellow transition-all opacity-100 md:opacity-0 group-hover/carousel:opacity-100">
                    <i class="fi fi-rr-angle-left text-xl mt-1 pr-1"></i>
                </button>
                
                <div id="carousel-enfants" class="flex overflow-x-auto snap-x snap-mandatory gap-4 md:gap-6 pb-6 hide-scrollbar" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <style>
                        .hide-scrollbar::-webkit-scrollbar {
                            display: none;
                        }
                    </style>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="/assets/img/external/2a03bb076a_1755595519748.jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="/assets/img/external/1986b3408c_Screenshot-20251031-111839-Linked-In.jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="/assets/img/external/637fa1765c_Whats-App-Image-2025-03-23-at-3-34-34-AM_2_.jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="/assets/img/external/502401f8be_Whats-App-Image-2025-03-23-at-3-34-34-AM_1_.jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                </div>

                <!-- Bouton Suivant -->
                <button onclick="document.getElementById('carousel-enfants').scrollBy({left: 300, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/90 backdrop-blur rounded-full shadow-xl flex items-center justify-center text-sterna-blue hover:bg-sterna-yellow transition-all opacity-100 md:opacity-0 group-hover/carousel:opacity-100">
                    <i class="fi fi-rr-angle-right text-xl mt-1 pl-1"></i>
                </button>
            </div>

            <a href="/" class="inline-flex items-center gap-2 mt-10 text-sterna-blue font-bold hover:text-sterna-yellow transition-colors border-b-2 border-transparent hover:border-sterna-yellow pb-1">
                <i class="fi fi-rr-arrow-small-left"></i> Retour à l'accueil
            </a>

        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>

