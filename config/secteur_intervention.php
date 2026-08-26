<section class="relative py-16 md:py-24 bg-gray-100" id="secteurs">
    <!-- SVG de séparation en haut de la section -->
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block text-sterna-yellow w-full h-12 md:h-20 text-gray-100 fill-current">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
    
    <div class="max-w-7xl mx-auto px-4 mt-8 md:mt-0">
        
        <div class="text-left mb-12">
            <h2 class="text-3xl md:text-3xl font-black text-sterna-blue uppercase tracking-tighter">
                Nos <span class="text-sterna-yellow">Secteurs</span> D'intervention
            </h2>
        </div>

        <!-- Onglets (Tabs) -->
        <div class="flex flex-wrap justify-center gap-3 mb-10">
            <button onclick="switchSecteur('education')" id="btn-education" class="secteur-btn active px-6 py-3 rounded-full font-bold text-xs sm:text-sm md:text-base transition-all duration-300 bg-sterna-blue text-white shadow-lg shadow-sterna-blue/30 transform hover:-translate-y-1">ÉDUCATION POPULAIRE</button>
            
            <button onclick="switchSecteur('solidarite')" id="btn-solidarite" class="secteur-btn px-6 py-3 rounded-full font-bold text-xs sm:text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-100 transform hover:-translate-y-1">SOLIDARITÉ INTERNATIONALE</button>
            
            <button onclick="switchSecteur('volontariat')" id="btn-volontariat" class="secteur-btn px-6 py-3 rounded-full font-bold text-xs sm:text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-100 transform hover:-translate-y-1">VOLONTARIAT</button>
            
            <button onclick="switchSecteur('developpement')" id="btn-developpement" class="secteur-btn px-6 py-3 rounded-full font-bold text-xs sm:text-sm md:text-base transition-all duration-300 bg-white text-gray-600 border border-gray-200 hover:bg-gray-100 transform hover:-translate-y-1">DÉVELOPPEMENT COMMUNAUTAIRE</button>
        </div>

        <!-- Conteneur des Contenus -->
        <div class="bg-gray-50 rounded-3xl shadow-lg overflow-hidden min-h-[400px]">
            
            <!-- 1. ÉDUCATION POPULAIRE -->
            <div id="content-education" class="secteur-content transition-all duration-500 opacity-100 block">
                <div class="flex flex-col lg:flex-row h-full">
                    <div class="lg:w-2/5 relative h-64 lg:h-auto min-h-[300px]">
                        <!-- Image illustrative -->
                        <img src="/assets/img/external/08faa183b4_4_1_.png" class="absolute inset-0 w-full h-full object-cover" alt="Éducation Populaire">
                        <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent hidden lg:block"></div>
                    </div>
                    <div class="lg:w-3/5 p-6 sm:p-8 md:p-12">
                        <div class="w-12 h-1 bg-sterna-yellow mb-6"></div>
                        <h3 class="text-2xl sm:text-3xl font-black text-sterna-blue mb-8 uppercase">Éducation Populaire</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Ateliers de formation citoyenne (masterclass, modules thématiques)</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Ciné-débats et cafés-débats</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Ateliers ludo-pédagogiques</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Formation de formateurs</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Production d'outils pédagogiques (livrets, jeux, supports de sensibilisation)</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Interventions en milieu scolaire ou dans les quartiers</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 2. SOLIDARITÉ INTERNATIONALE -->
            <div id="content-solidarite" class="secteur-content transition-all duration-500 opacity-0 hidden">
                <div class="flex flex-col lg:flex-row h-full">
                    <div class="lg:w-2/5 relative h-64 lg:h-auto min-h-[300px]">
                        <img src="https://i.postimg.cc/3JjVxhFv/1(1).png" class="absolute inset-0 w-full h-full object-cover" alt="Solidarité Internationale">
                        <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent hidden lg:block"></div>
                    </div>
                    <div class="lg:w-3/5 p-6 sm:p-8 md:p-12">
                        <div class="w-12 h-1 bg-sterna-yellow mb-6"></div>
                        <h3 class="text-2xl sm:text-3xl font-black text-sterna-blue mb-8 uppercase">Solidarité Internationale</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Actions d'Éducation à la Citoyenneté et à la Solidarité Internationale (ECSI)</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Partenariats et échanges Nord-Sud ou Sud-Sud entre organisations de différents pays</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Participation à des réseaux internationaux (comme RADSI, URUNANI Afrique)</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Plaidoyer sur des enjeux mondiaux (droits humains, climat, migrations)</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Mobilisation de ressources et collecte de fonds pour des projets de coopération</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Accueil de délégations étrangères, missions et voyages d'échange</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 3. VOLONTARIAT -->
            <div id="content-volontariat" class="secteur-content transition-all duration-500 opacity-0 hidden">
                <div class="flex flex-col lg:flex-row h-full">
                    <div class="lg:w-2/5 relative h-64 lg:h-auto min-h-[300px]">
                        <img src="/assets/img/external/0aea6ec811_3_1_.png" class="absolute inset-0 w-full h-full object-cover" alt="Volontariat">
                        <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent hidden lg:block"></div>
                    </div>
                    <div class="lg:w-3/5 p-6 sm:p-8 md:p-12">
                        <div class="w-12 h-1 bg-sterna-yellow mb-6"></div>
                        <h3 class="text-2xl sm:text-3xl font-black text-sterna-blue mb-8 uppercase">Volontariat</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Recrutement, formation et accompagnement de volontaires</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Programmes de volontariat national ou international (VSI, service civique, etc.)</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Chantiers de solidarité internationale ou camp des volontaires</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Mobilisation citoyenne ponctuelle (journées de salubrité, reboisement, comme lors de votre "Action Communautaire")</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Valorisation et reconnaissance des compétences acquises par les volontaires</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- 4. DÉVELOPPEMENT COMMUNAUTAIRE -->
            <div id="content-developpement" class="secteur-content transition-all duration-500 opacity-0 hidden">
                <div class="flex flex-col lg:flex-row h-full">
                    <div class="lg:w-2/5 relative h-64 lg:h-auto min-h-[300px]">
                        <img src="https://i.postimg.cc/X7KmYWk5/2(1).png" class="absolute inset-0 w-full h-full object-cover" alt="Développement Communautaire">
                        <div class="absolute inset-y-0 right-0 w-24 bg-gradient-to-l from-white to-transparent hidden lg:block"></div>
                    </div>
                    <div class="lg:w-3/5 p-6 sm:p-8 md:p-12">
                        <div class="w-12 h-1 bg-sterna-yellow mb-6"></div>
                        <h3 class="text-2xl sm:text-3xl font-black text-sterna-blue mb-8 uppercase">Développement Communautaire</h3>
                        <ul class="space-y-4">
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Appui à des projets communautaires locaux (eau, santé, éducation, infrastructures)</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Renforcement des capacités des organisations communautaires de base</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Actions directes avec les populations locales dans une logique d'apprentissage mutuel</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Appui à l'entrepreneuriat social et aux activités génératrices de revenus</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Rénovation ou dons d'équipements communautaires</span>
                            </li>
                            <li class="flex items-start gap-4">
                                <div class="mt-1 min-w-[24px] text-sterna-yellow text-lg"><i class="fi fi-rr-check-circle"></i></div>
                                <span class="text-gray-700 font-medium">Appui-conseil aux collectivités locales, création de coopératives ou groupements</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    function switchSecteur(secteur) {
        // Cacher tous les contenus
        const contents = document.querySelectorAll('.secteur-content');
        contents.forEach(el => {
            el.classList.remove('opacity-100');
            el.classList.add('opacity-0');
            setTimeout(() => {
                el.classList.add('hidden');
                el.classList.remove('block');
            }, 300); // Wait for fade out
        });

        // Reset de tous les boutons
        const btns = document.querySelectorAll('.secteur-btn');
        btns.forEach(el => {
            el.classList.remove('bg-sterna-blue', 'text-white', 'shadow-lg', 'shadow-sterna-blue/30');
            el.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        });

        // Afficher le contenu ciblé
        setTimeout(() => {
            const target = document.getElementById('content-' + secteur);
            target.classList.remove('hidden');
            target.classList.add('block');
            setTimeout(() => {
                target.classList.remove('opacity-0');
                target.classList.add('opacity-100');
            }, 50); // Slight delay to trigger CSS transition
        }, 300);

        // Activer le bouton ciblé
        const targetBtn = document.getElementById('btn-' + secteur);
        targetBtn.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        targetBtn.classList.add('bg-sterna-blue', 'text-white', 'shadow-lg', 'shadow-sterna-blue/30');
    }
</script>