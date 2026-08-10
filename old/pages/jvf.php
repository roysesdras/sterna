<?php $name = 'sterna africa'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>

<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- Header Section -->
    <header class="relative pt-32 pb-20 bg-sterna-blue overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-10">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 left-10 w-72 h-72 rounded-full bg-sterna-yellow blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-widest mb-4 backdrop-blur-sm border border-white/30">Journée Internationale</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 uppercase tracking-tight">Volontariat <span class="text-sterna-yellow">Français</span></h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto font-medium">Mettre en lumière l’engagement des volontaires mobilisés sur le terrain.</p>
        </div>

        <!-- SVG Bottom Curve -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 fill-current text-gray-50">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-16 -mt-10 relative z-30 mb-20">
        <div class="rounded-3xl shadow-xl p-2 md:p-4">
            

            <div class="mb-12 flex justify-center">
                <img src="/old/assets/img/festFrance.png" alt="Journée du Volontariat Français" class="max-w-full h-auto object-contain max-h-[400px] rounded-2xl drop-shadow-md">
            </div>

            <div class="prose prose-lg max-w-none text-gray-600">
                <p class="leading-relaxed mb-6">
                    Chaque année au mois d’octobre la Journée du Volontariat Français met en lumière l’engagement des volontaires mobilisés sur le terrain. Cet événement est porté par France volontaire, la plateforme française du volontariat international d’échange et de solidarité.
                </p>

                <p class="leading-relaxed mb-6">
                    Dans 22 des Espaces Volontariats que compte France Volontaires en Afrique, en Amérique latine et Caraïbes et en Asie, ce grand rendez-vous annuel réunit les acteurs du volontariat, institutionnels et associatifs, structures d’accueil et d’envoi, partenaires et volontaires locaux et internationaux. 
                </p>
                
                <div class="bg-blue-50 border-l-4 border-sterna-blue p-6 rounded-r-xl mb-6 my-8">
                    <p class="font-medium text-sterna-blue m-0">
                        Signé à ce jour par plus de 200 organisations dans le monde, l’Appel pour le volontariat de demain vient en réponse à des défis partagés (préservation de l’environnement, mobilités, inclusion sociale et professionnelle) qui appellent des réponses communes. À travers cinq recommandations, les signataires de l’Appel aspirent à insuffler un élan collectif pour que le volontariat de demain contribue activement à l’émergence d’une société de l’engagement solidaire et ouverte sur le monde.
                    </p>
                </div>

                <p class="leading-relaxed mb-6">
                    Pendant tout le mois d’octobre, les Espaces Volontariats organisent des temps de rencontres et de partage qui revêtiront différentes formes. Au programme : conférences et tables-rondes, débats, témoignages de volontaires, concours photo, concours d’éloquence, chasses aux trésors, expositions photo, pièces de théâtre…
                </p>
                
                <p class="leading-relaxed font-bold text-gray-900 mb-6 border-l-4 border-sterna-yellow pl-4">
                    C'est le moment pour nous, en tant que structure d'accueil, de mettre la lumière sur nos différents projets réalisés avec des partenaires et des volontaires français chaque année, surtout dans le cadre de nos chantiers de solidarité internationale.
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