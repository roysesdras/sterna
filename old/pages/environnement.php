<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <header class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <!-- Image de fond -->
            <img src="https://i.postimg.cc/SxPt6628/1-(260).jpg" alt="Enfants" class="w-full h-full object-cover opacity-60 mix-blend-luminosity">
            <!-- Surcouche bleue et dégradé -->
            <div class="absolute inset-0 bg-sterna-blue/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-sterna-blue via-sterna-bleu/80 to-transparent z-10"></div>
        </div>

        <div class="container mx-auto px-6 relative z-20 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Notre Public Cible</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">L'<span class="text-green-400">Environnement</span></h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Sensibilisation et développement durable.</p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-10 text-left text-gray-600 bg-gray-100 rounded-3xl shadow-xl -mt-10 relative z-30 mb-20">
        <div class="container mx-auto">
           
            <p class="text-lg leading-relaxed mb-4">
                Face aux urgences écologiques d'aujourd'hui, nous agissons concrètement sur le terrain, main dans la main avec les habitants, pour semer les graines d'une conscience environnementale durable.
            </p>

            <p class="text-lg leading-relaxed mb-4">
                Prendre soin de notre environnement, c'est protéger notre maison commune et garantir un avenir viable aux générations futures. Cet engagement se traduit par des actions de proximité fortes et impactantes :
            </p>

            
            <ul>
                <li class="mb-4">
                    <strong>Tri'Pop :</strong> Notre initiative ludique et éducative de sensibilisation au tri sélectif et à la gestion des déchets. Parce que la propreté d'un cadre de vie commence par les bons gestes du quotidien, Tri'Pop mobilise les habitants et les jeunes pour transformer les déchets en responsabilités partagées.
                </li>

                <li class="mb-4">
                    <strong>La protection de l'environnement et des espèces marines :</strong> Sensibiliser à la fragilité de nos écosystèmes côtiers et marins est vital. À travers des actions de nettoyage et de sensibilisation, nous luttons contre la pollution plastique et veillons à préserver la richesse de notre biodiversité locale.
                </li>

                <li class="mb-4">
                    <strong>Les campagnes de planting d'arbres :</strong> Rien de tel que de mettre les mains dans la terre pour agir directement contre le réchauffement climatique. À travers nos chantiers de reboisement, nous plantons des arbres pour redonner vie aux sols, lutter contre la désertification et offrir un bol d'oxygène durable à nos communautés.
                </li>
            </ul>

            <p class="text-lg leading-relaxed mb-4">
                Agir pour l'environnement avec Sterna Africa, c'est comprendre que chaque geste compte, que chaque arbre planté est un rempart pour demain, et que la terre nous le rend toujours au centuple.
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
                        <img src="https://i.postimg.cc/DzB33J8q/1-(93).jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/YSwQB0Jv/1-188.jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/vZKSrrgW/1-(136).jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/SxPt6628/1-(260).jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/x1ZFvvJz/1-(95).jpg" alt="Action jeunes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
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
