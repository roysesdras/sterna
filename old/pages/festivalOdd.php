<?php $name = 'sterna africa'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>

<body class="bg-gray-50 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- Header Section -->
    <header class="relative pt-32 pb-20 bg-indigo-600 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 left-10 w-72 h-72 rounded-full bg-sterna-yellow blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-widest mb-4 backdrop-blur-sm border border-white/30">Festival</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 uppercase tracking-tight">Festival <span class="text-sterna-yellow">ODD</span></h1>
            <p class="text-xl text-indigo-100 max-w-2xl mx-auto font-medium">S'engager pour les Objectifs de Développement Durable.</p>
        </div>

        <!-- SVG Bottom Curve -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 fill-current text-gray-50">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-16 -mt-10 relative z-30 mb-20">
        <div class="bg-white rounded-3xl shadow-xl p-8 md:p-12 border border-gray-100">
            
            <div class="text-center mb-12">
                <h2 class="text-3xl font-black text-gray-900 mb-4">Le Concept</h2>
                <div class="w-24 h-1 bg-indigo-500 mx-auto rounded-full"></div>
            </div>

            <div class="prose prose-lg max-w-none text-gray-600">
                <p class="leading-relaxed mb-6 font-bold text-gray-900 text-xl border-l-4 border-indigo-500 pl-4">
                    Les Objectifs de Développement Durable (ODD) sont un appel universel à l'action pour éliminer la pauvreté, protéger la planète et améliorer le quotidien de toutes les personnes partout dans le monde, tout en leur ouvrant des perspectives d'avenir.
                </p>

                <p class="leading-relaxed mb-6">
                    Au travers du <strong>Festival ODD</strong>, Sterna Africa s'engage à sensibiliser les populations, particulièrement la jeunesse, sur l'importance des 17 objectifs définis par les Nations Unies à l'horizon 2030. Nous croyons fermement qu'une action locale forte est le moteur essentiel de ce changement global.
                </p>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 mt-8">
                    <div class="bg-indigo-50 rounded-2xl p-6 text-center">
                        <div class="w-16 h-16 mx-auto bg-indigo-600 text-white rounded-full flex items-center justify-center text-2xl mb-4 shadow-md">
                            <i class="fi fi-rr-leaf"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Climat</h4>
                        <p class="text-sm text-gray-600">Protéger notre environnement et agir face à l'urgence climatique.</p>
                    </div>
                    <div class="bg-sterna-yellow/10 rounded-2xl p-6 text-center border border-sterna-yellow/20">
                        <div class="w-16 h-16 mx-auto bg-sterna-yellow text-gray-900 rounded-full flex items-center justify-center text-2xl mb-4 shadow-md">
                            <i class="fi fi-rr-scale"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Égalité</h4>
                        <p class="text-sm text-gray-600">Lutter contre toutes les formes d'inégalités et promouvoir l'inclusion.</p>
                    </div>
                    <div class="bg-sterna-blue/10 rounded-2xl p-6 text-center border border-sterna-blue/20">
                        <div class="w-16 h-16 mx-auto bg-sterna-blue text-white rounded-full flex items-center justify-center text-2xl mb-4 shadow-md">
                            <i class="fi fi-rr-hand-holding-heart"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-2">Solidarité</h4>
                        <p class="text-sm text-gray-600">Créer des partenariats durables pour la réalisation des objectifs.</p>
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mt-12 mb-6">Que faisons-nous dans le cadre du Festival ODD ?</h3>
                <p class="leading-relaxed mb-6">
                    Durant la période du festival, nous organisons de multiples activités : des ateliers de réflexion, des projections de documentaires, des campagnes de salubrité publique, et des conférences avec des acteurs clés du développement durable.
                </p>

                <div class="bg-gray-50 border border-gray-100 p-6 rounded-2xl mb-8">
                    <h4 class="font-bold text-indigo-600 mb-3 flex items-center gap-2">
                        <i class="fi fi-rr-bullseye"></i> Notre mission
                    </h4>
                    <p class="m-0 text-gray-700">
                        Transformer l'engagement citoyen en actions concrètes mesurables. Nous incitons la jeunesse à proposer des projets innovants répondant directement aux ODD sur leurs territoires (éducation de qualité, eau propre, énergie abordable, etc.).
                    </p>
                </div>

                <div class="mt-12 text-center">
                    <a href="/old/actualite/toutes_les_actualites.php" class="inline-flex items-center justify-center px-8 py-4 bg-indigo-600 text-white font-bold rounded-full hover:bg-indigo-700 transition-colors duration-300 shadow-lg hover:shadow-xl group">
                        Rejoindre le mouvement <i class="fi fi-rr-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>

</body>
</html>