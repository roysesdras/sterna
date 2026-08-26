<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <header class="relative pt-32 pb-20 md:pt-48 md:pb-40 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <!-- Image de fond -->
            <img src="/assets/img/external/f5adb3cec9_stafrica3.jpg" alt="Enfants" class="w-full h-full object-cover opacity-60 mix-blend-luminosity">
            <!-- Surcouche bleue et dégradé -->
            <div class="absolute inset-0 bg-sterna-blue/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-sterna-blue via-sterna-blue/80 to-transparent z-10"></div>
        </div>
        <div class="container mx-auto px-6 relative z-20 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Notre Public Cible</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Les <span class="text-sterna-yellow">Enfants</span></h1>
            <p class="text-lg md:text-xl text-blue-50 max-w-2xl mx-auto font-medium">Éducation inclusive et bien-être en milieu rural.</p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-10 text-left text-gray-600 bg-gray-100 rounded-3xl shadow-xl -mt-10 relative z-30 mb-10">
        <div class="container max-auto">
            <p class="text-lg leading-relaxed mb-4">
                Sterna Africa intervient auprès des enfants dans le cadre de ses missions de développement et de solidarité. Les enfants sont au cœur de nos préoccupations, car ils représentent l'avenir des communautés que nous accompagnons.
            </p>

            <h2 class="text-3xl font-bold mb-4 text-gray-900">Éveiller, éduquer et accompagner les enfants en milieu rural</h2>

            <p class="text-lg leading-relaxed mb-4">Dans les villages et les localités isolées, l'accès aux loisirs éducatifs, au soutien scolaire et aux espaces d'expression est souvent un défi de taille. C'est précisément là que nos équipes et nos volontaires agissent. Notre mission ne se limite pas à distribuer du matériel ou à construire des infrastructures : nous créons des ponts d'opportunités pour que chaque enfant, qu'il grandisse en ville ou en milieu rural, puisse rêver grand, cultiver sa curiosité et révéler tout son potentiel.
            </p>  

            <p class="text-lg leading-relaxed mb-4">
                Cet engagement se traduit concrètement à travers des programmes phares conçus pour dynamiser le quotidien des enfants : 
            </p>
            <ul>
                <li class="mb-4"><strong>Educ'Moi</strong> : Notre initiative dédiée au soutien à l'éducation et à l'apprentissage. À travers des sessions de mentorat, des ateliers de lecture et un accompagnement de proximité, nous luttons contre le décrochage scolaire et offrons aux enfants les clés indispensables pour réussir leur parcours éducatif.
                </li>
                <li class="mb-4"><strong>Vacances Fun</strong> : Parce que l'apprentissage passe aussi par le jeu, le sport et la créativité, ce programme transforme les périodes de vacances en moments de pure joie et de socialisation. Ateliers artistiques, tournois sportifs et jeux d'équipe permettent aux enfants de s'évader, de tisser des liens solides et de grandir dans un environnement bienveillant.
                </li>

                <li class="mb-4"><strong>La Journée mondiale des droits de l'enfant</strong> : Chaque année, nous faisons résonner la voix des plus jeunes lors de cette date symbolique. C'est l'occasion de sensibiliser les communautés, d'offrir une tribune aux enfants pour exprimer leurs droits, leurs besoins et leurs aspirations, et de rappeler à tous que leur protection et leur épanouissement sont une priorité absolue.
                </li>
            </ul>

            <p class="text-lg leading-relaxed mb-4 mt-6 font-medium">
                Agir aux côtés des enfants en milieu rural, c'est leur redonner confiance en eux et leur montrer qu'ils ne sont jamais oubliés, peu importe l'éloignement géographique. Nous croyons fermement que chaque enfant guidé, écouté et soutenu aujourd'hui devient un acteur de changement de demain.
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
                        <img src="/assets/img/external/b67ac83b9b_stafrica.jpg" alt="Action Enfants" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/Hxb3wDXv/tripo.jpg" alt="Action Enfants" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="/assets/img/external/c41b9416c0_bj-JMDE.jpg" alt="Action Enfants" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/sfBQZLK8/1768314299395-e-1770249600-v-beta-t-vxr-RXD0PEVNu-Odm-IJR3W5mk-JWBWdj6UMNEf-M64T5Rb-Q.jpg" alt="Action Enfants" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/sfBQZLK8/1768314299395-e-1770249600-v-beta-t-vxr-RXD0PEVNu-Odm-IJR3W5mk-JWBWdj6UMNEf-M64T5Rb-Q.jpg" alt="Action Enfants" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>

                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="/assets/img/external/c2253103c9_1755588034707.jpg" alt="Action Enfants" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                </div>

                <!-- Bouton Suivant -->
                <button onclick="document.getElementById('carousel-enfants').scrollBy({left: 300, behavior: 'smooth'})" class="absolute right-2 top-1/2 -translate-y-1/2 z-10 w-12 h-12 bg-white/90 backdrop-blur rounded-full shadow-xl flex items-center justify-center text-sterna-blue hover:bg-sterna-yellow transition-all opacity-100 md:opacity-0 group-hover/carousel:opacity-100">
                    <i class="fi fi-rr-angle-right text-xl mt-1 pl-1"></i>
                </button>
            </div>

            <a href="/" class="inline-flex items-center gap-2 mt-4 text-sterna-blue font-bold hover:text-sterna-yellow transition-colors border-b-2 border-transparent hover:border-sterna-yellow pb-1">
                <i class="fi fi-rr-arrow-small-left"></i> Retour à l'accueil
            </a>
        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>
