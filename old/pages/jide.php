<?php $name = 'sterna africa'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>

<body class="bg-gray-50 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- Header Section -->
    <header class="relative pt-32 pb-20 bg-sterna-blue overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 left-10 w-72 h-72 rounded-full bg-sterna-yellow blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-widest mb-4 backdrop-blur-sm border border-white/30">Journée Internationale</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 uppercase tracking-tight">Droits des <span class="text-sterna-yellow">Enfants</span></h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto font-medium">Soutenons et célébrons chaque année le droit des enfants lors de la Journée mondiale de l'enfance.</p>
        </div>

        <!-- SVG Bottom Curve -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 fill-current text-gray-50">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-16 -mt-10 relative z-30 mb-20">
        <div class="rounded-3xl p-2 md:p-4">
        

            <div class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-gray-100">
                <img src="/old/assets/img/droitEnfant.jpg" alt="Journée Internationale des Droits des Enfants" class="w-full h-auto object-cover max-h-[500px]">
            </div>

            <div class="prose prose-lg max-w-none text-gray-600">
                <p class="leading-relaxed mb-6">
                    Le 20 novembre 1989, l’ONU adoptait à l’unanimité la Convention relative aux droits de l’Enfant : les droits de chaque enfant du monde étaient désormais reconnus par un traité international, ratifié par 195 États ! Depuis, le 20 novembre a été déclaré Journée internationale des droits de l’enfant – un temps fort que l’UNICEF ne manque pas de marquer chaque année.
                </p>

                <p class="leading-relaxed mb-6">
                    En 1954, l’Assemblée générale a recommandé à tous les pays d’instituer une "Journée mondiale de l’enfance", qui serait une journée de fraternité mondiale et de compréhension entre les enfants, et d’activités favorisant le bien-être des enfants du monde entier. Elle a proposé aux gouvernements que cette Journée soit célébrée à la date qui leur semblait la plus appropriée. C'est le 20 novembre qui a été choisi, à la fois jour d'adoption par l’Assemblée de la Déclaration des droits de l’enfant en 1959, et de la Convention relative aux droits de l’enfant, signée en 1989.
                </p>

                <div class="bg-blue-50 border-l-4 border-sterna-blue p-6 rounded-r-xl mb-6 my-8">
                    <p class="font-medium text-sterna-blue m-0">
                        Cette Convention, qui est le traité international le plus ratifié en matière de droits de l'homme, définit une liste de droits de l'enfant comprenant le droit à la vie, à la santé, à l'éducation et le droit de jouer, ainsi que le droit à une vie de famille, à être protégé de la violence et de la discrimination, et de faire entendre sa voix.
                    </p>
                </div>

                <p class="leading-relaxed mb-6">
                    Sur la base de cette Convention et des efforts conjoints de l'ensemble des pays et régions, nous soutenons et célébrons chaque année le droit des enfants lors de la Journée mondiale de l'enfance. Par le dialogue et l'action, bâtissons un monde où les enfants peuvent s'épanouir librement.
                </p>

                <h3 class="text-2xl font-bold text-gray-900 mt-10 mb-4">Notre action sur le terrain</h3>
                <p class="leading-relaxed mb-4">
                    Chaque année, ce rendez-vous est l'un des plus importants dans notre calendrier sur toutes les antennes et nous faisons des enfants :
                </p>
                <ul class="list-disc pl-6 mb-6 space-y-2 font-medium text-gray-700">
                    <li>Des participants actifs à leur propre vie et à celle de leur collectivité.</li>
                    <li>Des citoyens actifs qui peuvent et doivent contribuer de manière significative aux décisions qui influencent leur vie.</li>
                </ul>

                <p class="leading-relaxed mb-6">
                    Cette journée est une excellente occasion pour les enseignants, les éducateurs, les parents et les fournisseurs de soins d'informer les enfants de leurs droits. Des échanges autour de leurs droits et devoirs, des ateliers de dessin et de peinture, des jeux et animations, des concours de culture, des théâtres, des contes et récits, etc. Voilà plusieurs activités que nous menons chaque année avec les enfants pour commémorer cette journée si spéciale.
                </p>

                <div class="mt-10 text-center">
                    <a href="/old/actualite/toutes_les_actualites.php" class="inline-flex items-center justify-center px-8 py-4 bg-sterna-yellow text-gray-900 font-bold rounded-full hover:bg-sterna-blue hover:text-white transition-colors duration-300 shadow-lg hover:shadow-xl group">
                        Découvrez nos activités <i class="fi fi-rr-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>

</body>
</html>