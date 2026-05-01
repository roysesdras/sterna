<section class="py-10" id="secteurs">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="mb-8">
            <h2 class="text-4xl font-black text-sterna-blue uppercase tracking-tighter border-l-8 border-sterna-orange pl-6">
                Nos Secteurs <br><span class="text-sterna-orange">d'Intervention</span>
            </h2>
            <p class="mt-6 text-gray-500 font-medium max-w-3xl text-lg">
                Sterna Africa : Association d'Éducation à la Citoyenneté et à la Solidarité Internationale (ECSI), engagée pour la transformation sociale durable à travers le volontariat et le développement local.
            </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-12">
            
            <div class="lg:w-1/3 space-y-4">
                <button onclick="switchSecteur('france')" id="btn-france" class="secteur-btn active w-full flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300 text-left group">
                    <span class="font-black uppercase tracking-widest text-sm text-sterna-blue">Antenne France (Lyon)</span>
                    <i class="fi fi-rr-arrow-right"></i>
                </button>
                
                <button onclick="switchSecteur('volontariat')" id="btn-volontariat" class="secteur-btn w-full flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300 text-left group text-gray-400 border-gray-100 hover:border-sterna-orange">
                    <span class="font-black uppercase tracking-widest text-sm">Volontariat Sans Frontières</span>
                    <i class="fi fi-rr-arrow-right"></i>
                </button>

                <button onclick="switchSecteur('developpement')" id="btn-developpement" class="secteur-btn w-full flex items-center justify-between p-4 rounded-2xl border-2 transition-all duration-300 text-left group text-gray-400 border-gray-100 hover:border-sterna-orange">
                    <span class="font-black uppercase tracking-widest text-sm">Développement & Impact</span>
                    <i class="fi fi-rr-arrow-right"></i>
                </button>
            </div>

            <div class="lg:w-2/3 rounded-3xl p-2 md:p-4 min-h-[400px] border border-gray-100">
                
                <div id="content-france" class="secteur-content transition-all duration-500">
                    <div class="flex flex-col xl:flex-row gap-10">
                        <div class="flex-1">
                            <span class="text-xs font-black text-white bg-sterna-orange px-4 py-1 rounded-full uppercase tracking-widest">Le pont entre l'Europe et l'Afrique</span>
                            <h3 class="text-3xl font-black text-sterna-blue mt-6 mb-4">Engagement & Échanges Interculturels</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed italic">"Promouvoir l’Éducation à la Citoyenneté et à la Solidarité Internationale (ECSI) pour co-construire des solutions aux défis locaux et globaux."</p>
                            
                            <div class="space-y-4">
                                <div class="p-4 bg-white rounded-xl shadow-sm border-l-4 border-blue-500">
                                    <h5 class="font-bold text-sterna-blue text-sm uppercase">Missions de Terrain et Animations</h5>
                                    <p class="text-sm text-gray-500 mt-1">Soutien scolaire, animation d’ateliers, réfections et animations, création d’outils pédagogiques.</p>
                                </div>
                            </div>
                        </div>
                        <div class="xl:w-1/3">
                            <img src="https://i.postimg.cc/xCGNgM1v/Whats-App-Image-2025-03-23-at-3-21-23-AM.jpg" class="rounded-2xl shadow-lg w-full h-80 object-cover" alt="Antenne France">
                        </div>
                    </div>
                </div>

                <div id="content-volontariat" class="secteur-content hidden transition-all duration-500">
                    <div class="mb-4">
                        <h3 class="text-3xl font-black text-sterna-orange uppercase">Une Force sans frontières</h3>
                        <p class="text-gray-500 font-bold mt-2 uppercase text-xs tracking-widest">VSI, Volontariat Sud-Sud, Sud-Nord et programmes de réciprocité</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="p-4 bg-white rounded-2xl text-center shadow-md">
                            <i class="fi fi-sr-heart text-sterna-rose text-2xl"></i>
                            <h5 class="font-black text-sterna-blue text-sm mt-3 uppercase">Solidaire</h5>
                            <p class="text-[13px] text-gray-400 mt-1">Chantiers d'été et immersion locale profonde.</p>
                        </div>
                        <div class="p-4 bg-white rounded-2xl text-center shadow-md">
                            <i class="fi fi-sr-world text-sterna-rose text-2xl"></i>
                            <h5 class="font-black text-sterna-blue text-sm mt-3 uppercase">Sud-Nord</h5>
                            <p class="text-[13px] text-gray-400 mt-1">Échanges entre l'Afrique de l'Ouest et l’Europe.</p>
                        </div>
                        <div class="p-4 bg-white rounded-2xl text-center shadow-md">
                            <i class="fi fi-sr-refresh text-sterna-rose text-2xl"></i>
                            <h5 class="font-black text-sterna-blue text-sm mt-3 uppercase">Réciprocité</h5>
                            <p class="text-[13px] text-gray-400 mt-1">Accueil de volontaires en France via le SCD.</p>
                        </div>
                    </div>

                    <p class="text-[10px] font-black uppercase text-gray-400 mb-4 tracking-[0.2em]">Galerie Volontariat</p>
                    <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                        <img src="https://i.postimg.cc/Cdp0mcJJ/26-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="V1">
                        <img src="https://i.postimg.cc/WpFJYtXJ/27-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="V2">
                        <img src="https://i.postimg.cc/g0tnNPhD/28-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="V3">
                        <img src="https://i.postimg.cc/5t2XBtXy/29-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="V4">
                        <img src="https://i.postimg.cc/m271RJxL/30-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="V5">
                    </div>
                </div>

                <div id="content-developpement" class="secteur-content hidden transition-all duration-500">
                    <h3 class="text-3xl font-black text-sterna-blue mb-8 uppercase">Développement & Services Sociaux</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        <div class="flex items-start gap-4 p-4 bg-white rounded-2xl shadow-md border-r-4 border-sterna-keppel">
                            <div class="text-sterna-keppel text-xl"><i class="fi fi-sr-book-alt"></i></div>
                            <div>
                                <h5 class="font-black text-sterna-blue text-sm uppercase">Éducation & Inclusion</h5>
                                <p class="text-[13px] text-gray-500 mt-1 leading-relaxed">Déjeuner des démunis, MAA (Mouvement d'Appui à l'Apprentissage), réhabilitation d'écoles.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-white rounded-2xl shadow-md border-r-4 border-sterna-orange">
                            <div class="text-sterna-orange text-xl"><i class="fi fi-sr-woman-side"></i></div>
                            <div>
                                <h5 class="font-black text-sterna-blue text-sm uppercase">Femmes & Autonomie</h5>
                                <p class="text-[13px] text-gray-500 mt-1 leading-relaxed">Projet "Sang Tabou" : Autonomie économique et hygiène menstruelle.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-4 bg-white rounded-2xl shadow-md border-r-4 border-red-500">
                            <div class="text-red-500 text-xl"><i class="fi fi-sr-heartbeat"></i></div>
                            <div>
                                <h5 class="font-black text-sterna-blue text-xs uppercase">Santé & Prévention</h5>
                                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Campagnes don de sang, lutte contre l'Hépatite B et la Lèpre.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm border-r-4 border-green-500">
                            <div class="text-green-500 text-xl"><i class="fi fi-sr-leaf"></i></div>
                            <div>
                                <h5 class="font-black text-sterna-blue text-xs uppercase">Environnement</h5>
                                <p class="text-[11px] text-gray-500 mt-1 leading-relaxed">Éco-Citoyenneté, planting d’arbres, MAMP et Latrines Biofil.</p>
                            </div>
                        </div>
                    </div>

                    <p class="text-[10px] font-black uppercase text-gray-400 mb-4 tracking-[0.2em]">Impact Terrain</p>
                    <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide">
                        <img src="https://i.postimg.cc/qMvWdV6n/18-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D1">
                        <img src="https://i.postimg.cc/W4gH7sxR/20-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D3">
                        <img src="https://i.postimg.cc/fLQ64VYT/21-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D4">
                        <img src="https://i.postimg.cc/rs83m7hB/22-min.png" class="h-32 rounded-xl shrink-0 shadow-md" alt="D5">
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