<?php $name = 'sterna africa'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>

<body class="bg-gray-50 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- Header Section -->
    <header class="relative pt-32 pb-20 bg-green-700 overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 left-10 w-72 h-72 rounded-full bg-sterna-yellow blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/30 text-white text-xs font-bold uppercase tracking-widest mb-4 backdrop-blur-sm border border-white/50">Festival</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white mb-6 uppercase tracking-tight">Festival <span class="text-sterna-yellow">Alimenterre</span></h1>
            <p class="text-xl text-green-100 max-w-2xl mx-auto font-medium">Un évènement incontournable sur l'alimentation durable et solidaire.</p>
        </div>

        <!-- SVG Bottom Curve -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 fill-current text-gray-50">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </header>

    <main class="container mx-auto px-4 py-16 -mt-10 relative z-30 mb-20">
        <div class="rounded-3xl shadow-xl p-2 md:p-4 ">
            <div class="mb-12 rounded-2xl overflow-hidden flex justify-center">
                <img src="/old/assets/img/alimentFestisol.jpeg" alt="Festival Alimenterre" class="max-w-full h-auto object-cover max-h-[500px] rounded-2xl">
            </div>

            <div class="prose prose-lg max-w-none text-gray-600">
                <p class="leading-relaxed mb-6 font-bold text-gray-900 text-xl border-l-4 border-green-500 pl-4">
                    Le festival ALIMENTERRE est un évènement incontournable sur l'alimentation durable et solidaire.
                </p>

                <p class="leading-relaxed mb-8">
                    Le festival ALIMENTERRE a vu le jour en 2007 dans un cinéma parisien. Depuis, il est devenu un évènement international sur l’alimentation durable et solidaire organisé chaque année du 15 octobre au 30 novembre. Autour d'une sélection de 8 films documentaires, il amène les citoyens à s’informer et comprendre les enjeux agricoles et alimentaires en France et dans le monde, afin qu’ils participent à la co-construction de systèmes alimentaires durables et solidaires et au droit à l’alimentation.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                    <div class="bg-green-50 rounded-2xl p-6 border border-green-100 shadow-sm">
                        <div class="w-12 h-12 bg-green-600 text-white rounded-xl flex items-center justify-center mb-4 text-2xl">
                            <i class="fi fi-rr-users"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-3">65 000 personnes et des milliers d'évènements dans 600 communes</h4>
                        <p class="text-sm leading-relaxed m-0 text-gray-700">
                            Durant 1 mois et demi, plus d’un millier d’évènements sont organisés dans 600 communes et une dizaine de pays : projection-débat, marché alimentaire et solidaire, atelier cuisine bio, locale et équitable... Plus de 65 000 personnes y participent chaque année, dont une majorité de jeunes.
                        </p>
                    </div>

                    <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100 shadow-sm">
                        <div class="w-12 h-12 bg-sterna-blue text-white rounded-xl flex items-center justify-center mb-4 text-2xl">
                            <i class="fi fi-rr-globe"></i>
                        </div>
                        <h4 class="font-bold text-gray-900 mb-3">Un regard croisé sur l'alimentation dans le monde</h4>
                        <p class="text-sm leading-relaxed m-0 text-gray-700">
                            Durant le Festival, le CFSI invite trois intervenants d’Afrique, d’Asie ou d’Amérique latine engagés pour une agriculture durable. Ils se joignent aux intervenants français pour débattre et assurer un regard croisé des enjeux locaux et mondiaux.
                        </p>
                    </div>
                </div>

                <div class="bg-yellow-50 border-l-4 border-sterna-yellow p-6 rounded-r-xl mb-10">
                    <h4 class="font-bold text-gray-900 mb-2">Des milliers d'organisateurs autour de valeurs communes</h4>
                    <p class="text-sm leading-relaxed m-0 text-gray-700">
                        Coordonné par le CFSI, le Festival ALIMENTERRE est organisé par plus de 1 000 organisations : lycées, cinémas, associations, fermes, etc. Le CFSI propose des outils pédagogiques, des films, et un accompagnement de proximité.
                    </p>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mt-12 mb-6">Que faisons-nous ?</h3>
                <p class="leading-relaxed mb-6">
                    Durant la période du Festival Alimenterre, nous organisons plusieurs <strong>Projections-Débats</strong> autour des films mis à disposition par le CFSI en invitant les populations aux échanges et à réfléchir à un changement de nos habitudes alimentaires.
                </p>
                <p class="leading-relaxed mb-8">
                    Nous faisons aussi plusieurs documentaires de découvertes culinaires sur des mets locaux, mais aussi sur des artisans locaux et leur créativité. Le Festival Alimenterre a lieu principalement sur nos antennes du Bénin et de la Côte d'Ivoire.
                </p>

                <div class="mt-10 text-center flex flex-col md:flex-row gap-4 justify-center">
                    <a href="/old/actualite/toutes_les_actualites.php" class="inline-flex items-center justify-center px-8 py-4 bg-green-600 text-white font-bold rounded-full hover:bg-green-700 transition-colors duration-300 shadow-lg hover:shadow-xl group">
                        Découvrez nos activités <i class="fi fi-rr-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="https://www.facebook.com/profile.php?id=100076369053850" target="_blank" class="inline-flex items-center justify-center px-8 py-4 bg-gray-100 text-gray-700 font-bold rounded-full hover:bg-gray-200 transition-colors duration-300 shadow-sm group">
                        Suivez-nous sur Facebook <i class="fi fi-brands-facebook ml-2"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>

</body>
</html>