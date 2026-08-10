<section class="relative py-4 md:py-20" id="secteurs">
    <!-- SVG de séparation en haut de la section -->
    <div class="absolute top-0 left-0 w-full overflow-hidden leading-none">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block text-sterna-yellow w-full h-12 md:h-20 text-gray-100 fill-current">
            <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
        </svg>
    </div>
    <div class="max-w-7xl mx-auto px-2">
        
        <div class="mb-8 mt-8 md:mt-0">
            <h2 class="text-2xl md:text-4xl font-black text-sterna-blue uppercase tracking-tighter border-l-8 border-sterna-blue pl-6">
                Nos Secteurs <br>d'<span class="text-sterna-yellow">Intervention</span>
            </h2>
            
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="lg:w-1/3 space-y-4 mt-5">
                <button onclick="switchSecteur('france')" id="btn-france" class="secteur-btn active w-full flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300 text-left group">
                    <span class="font-black uppercase tracking-widest text-sm text-sterna-blue">Volontariat Sans Frontières</span>
                    <i class="fi fi-rr-arrow-right"></i>
                </button>

                <button onclick="switchSecteur('developpement')" id="btn-developpement" class="secteur-btn w-full flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300 text-left group text-gray-700 border-sterna-yellow">
                    <span class="font-black uppercase tracking-widest text-sm">Développement & Impact</span>
                    <i class="fi fi-rr-arrow-right"></i>
                </button>
            </div>

            <div class="lg:w-2/3 rounded-3xl p-2 md:p-4 min-h-[350px]">
                
                <div id="content-france" class="secteur-content transition-all duration-500">
                    <div class="flex flex-col xl:flex-row gap-10">
                        <div class="flex-1 order-2 md:order-1">
                            <h3 class="text-3xl font-black text-sterna-blue mb-4">Engagement & Échanges Interculturels</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed italic">"Promouvoir l’ECSI pour co-construire des solutions aux défis locaux et globaux."</p>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-gray-100 rounded-xl shadow-md">
                                    <h5 class="font-bold text-sterna-blue text-sm uppercase">Missions de Terrain et Animations</h5>
                                    <p class="text-sm text-gray-500 mt-1">Soutien scolaire, animation d’ateliers, réfections et création d’outils pédagogiques.</p>
                                </div>
                            </div>
                        </div>
                        <div class="xl:w-1/3 order-1 md:order-2">
                            <img src="https://i.postimg.cc/xCGNgM1v/Whats-App-Image-2025-03-23-at-3-21-23-AM.jpg" 
                            class="rounded-2xl shadow-lg w-full h-[400px] sm:h-[500px] md:h-80 object-cover" 
                            alt="Antenne France">
                        </div>
                    </div>
                </div>

                <div id="content-developpement" class="secteur-content hidden transition-all duration-500">
                    <h3 class="text-3xl font-black text-sterna-blue mb-8 uppercase">Développement & Services Sociaux</h3>

                    <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide order-1 md:order-2">
                        <img src="https://i.postimg.cc/qMvWdV6n/18-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D1">
                        <img src="https://i.postimg.cc/W4gH7sxR/20-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D3">
                        <img src="https://i.postimg.cc/fLQ64VYT/21-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D4">
                        <img src="https://i.postimg.cc/rs83m7hB/22-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D5">
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 order-2 md:order-1">
                        <div class="flex items-start gap-4 p-4 bg-gray-100 rounded-2xl shadow-md">
                            <div class="text-sterna-keppel text-xl"><i class="fi fi-sr-book-alt"></i></div>
                            <div>
                                <h5 class="font-black text-sterna-blue text-sm uppercase">Éducation & Inclusion</h5>
                                <p class="text-[13px] text-gray-500 mt-1 leading-relaxed">Déjeuner des démunis, MAA (Mouvement d'Appui à l'Apprentissage), réhabilitation d'écoles.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 bg-gray-100 rounded-2xl shadow-md">
                            <div class="text-sterna-orange text-xl"><i class="fi fi-sr-woman-side"></i></div>
                            <div>
                                <h5 class="font-black text-sterna-blue text-sm uppercase">Femmes & Autonomie</h5>
                                <p class="text-[13px] text-gray-500 mt-1 leading-relaxed">Projet "Sang Tabou" : Autonomie économique et hygiène menstruelle.</p>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .secteur-btn.active {
        background-color: white;
        border-color: #0f277e;
        box-shadow: 0 10px 30px rgba(15, 39, 126, 0.08);
        transform: translateX(12px);
    }
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
    function switchSecteur(secteur) {
        document.querySelectorAll('.secteur-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.secteur-btn').forEach(el => {
            el.classList.remove('active');
            el.classList.add('text-gray-400', 'border-gray-100');
            el.querySelector('span').classList.remove('text-sterna-blue');
        });

        document.getElementById('content-' + secteur).classList.remove('hidden');
        const btn = document.getElementById('btn-' + secteur);
        btn.classList.add('active');
        btn.classList.remove('text-gray-400', 'border-gray-100');
        btn.querySelector('span').classList.add('text-sterna-blue');
    }
</script>