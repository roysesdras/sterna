<?php $name = 'sterna africa'; ?>
<!DOCTYPE html>
<html lang="fr">
<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>

<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <!-- Header Section -->
    <header class="relative pt-32 pb-20 bg-sterna-yellow overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-white blur-3xl"></div>
            <div class="absolute top-1/2 left-10 w-72 h-72 rounded-full bg-sterna-blue blur-3xl"></div>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-white/50 text-gray-900 text-xs font-bold uppercase tracking-widest mb-4 backdrop-blur-sm border border-white/50">Festival</span>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-gray-900 mb-6 uppercase tracking-tight">Festival des <span class="text-sterna-blue">Solidarités</span></h1>
            <p class="text-xl text-gray-800 max-w-2xl mx-auto font-medium">Offrir un espace à toutes celles et ceux qui souhaitent montrer les solidarités en action.</p>
        </div>

        <!-- SVG Bottom Curve -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none rotate-180">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none" class="relative block w-full h-12 md:h-20 fill-current text-gray-100">
                <path d="M321.39,56.44c58-10.79,114.16-30.13,172-41.86,82.39-16.72,168.19-17.73,250.45-.39C823.78,31,906.67,72,985.66,92.83c70.05,18.48,146.53,26.09,214.34,3V0H0V27.35A600.21,600.21,0,0,0,321.39,56.44Z"></path>
            </svg>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-2 py-16 -mt-10 relative z-30 mb-20">
        <div class="bg-gray-100 rounded-3xl shadow-xl p-4 md:p-4">

            <div class="mb-12 rounded-2xl overflow-hidden shadow-lg flex justify-center">
                <img src="/old/assets/img/concept.jpeg" alt="Festival des Solidarités" class="max-w-full h-auto object-cover max-h-[500px]">
            </div>

            <div class="prose prose-lg max-w-none text-gray-600">
                <p class="leading-relaxed mb-6 font-bold text-gray-900 text-xl border-l-4 border-sterna-yellow pl-4">
                    Depuis plus de 20 ans, le Festival des Solidarités (FESTISOL) offre un espace à toutes celles et ceux qui souhaitent montrer les solidarités en action sur leur territoire.
                </p>

                <p class="leading-relaxed mb-6">
                    Chaque année en Novembre, des milliers de personnes organisent pendant deux semaines des événements conviviaux et engagés pour parler de solidarité, du local à l’international. Partout, une grande diversité d’acteurs s’engage au quotidien pour faire changer les choses à leur niveau : associations, établissements scolaires, collectivités, entreprises sociales, citoyens...
                </p>

                <p class="leading-relaxed mb-8">
                    Animations de rue, pièces de théâtre, jeux de sensibilisation, projections-débats, expositions, repas partagés, marchés solidaires, concerts, spectacles de danse, ateliers pratiques... Une diversité d’événements pour toucher tous les publics et les inviter à devenir acteurs d’un monde plus juste, solidaire et durable.
                </p>

                <!-- Grid de valeurs / principes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="text-sterna-blue text-3xl mb-3"><i class="fi fi-rr-globe"></i></div>
                        <h4 class="font-bold text-gray-900 mb-2">Pour une solidarité globale</h4>
                        <p class="text-sm m-0">Les vies sont interdépendantes et la solidarité est avant tout un choix : c’est décider de voir autrui comme une force pour transformer ensemble notre monde.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="text-sterna-yellow text-3xl mb-3"><i class="fi fi-rr-scale"></i></div>
                        <h4 class="font-bold text-gray-900 mb-2">Défendre les droits humains</h4>
                        <p class="text-sm m-0">Nous énonçons un postulat fort : chaque être humain, quel que soit son âge, doit voir garantir l’ensemble de ses droits.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="text-sterna-yellow text-3xl mb-3"><i class="fi fi-rr-hands-heart"></i></div>
                        <h4 class="font-bold text-gray-900 mb-2">Citoyenneté mondiale</h4>
                        <p class="text-sm m-0">La solidarité n’a de sens que si elle est globale. La restreindre ne ferait qu’alimenter les conflits et les clivages.</p>
                    </div>
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                        <div class="text-sterna-blue text-3xl mb-3"><i class="fi fi-rr-users"></i></div>
                        <h4 class="font-bold text-gray-900 mb-2">Agir ensemble</h4>
                        <p class="text-sm m-0">Associer chacun à la compréhension des enjeux et construire ensemble des solutions dans une perspective d’émancipation collective.</p>
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-sterna-blue p-6 rounded-r-xl mb-12">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">4 bonnes raisons de participer</h3>
                    <ul class="list-none pl-0 m-0 space-y-4">
                        <li class="flex items-start">
                            <i class="fi fi-rr-check text-sterna-blue mt-1 mr-3"></i>
                            <div>
                                <strong class="text-gray-900">Se mettre en collectif</strong><br>
                                <span class="text-sm">Mutualisez vos ressources, vos compétences et vos moyens d’action, et apprenez les un·e·s des autres.</span>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fi fi-rr-check text-sterna-blue mt-1 mr-3"></i>
                            <div>
                                <strong class="text-gray-900">Créer un lien territorial</strong><br>
                                <span class="text-sm">Fédérer un large réseau d’actrices et d’acteurs pour faire émerger de nouvelles actions communes.</span>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fi fi-rr-check text-sterna-blue mt-1 mr-3"></i>
                            <div>
                                <strong class="text-gray-900">Une visibilité accrue</strong><br>
                                <span class="text-sm">Bénéficiez d'une grande campagne de communication nationale et de supports gratuits pour vos événements.</span>
                            </div>
                        </li>
                        <li class="flex items-start">
                            <i class="fi fi-rr-check text-sterna-blue mt-1 mr-3"></i>
                            <div>
                                <strong class="text-gray-900">Un accompagnement continu</strong><br>
                                <span class="text-sm">Bénéficiez d’outils pédagogiques, de fiches pratiques, de formations et de conseils personnalisés.</span>
                            </div>
                        </li>
                    </ul>
                </div>

                <h3 class="text-2xl font-bold text-gray-900 mt-12 mb-6">Que faisons-nous dans le cadre du Festisol ?</h3>
                <p class="leading-relaxed mb-8">
                    En tant qu'organisation de la société civile, nous menons plusieurs activités de solidarité dans la période du festival sur toutes nos antennes avec une attention particulière sur le Bénin et la Côte d'Ivoire.
                </p>

                <div class="space-y-8">
                    <!-- Action Bénin -->
                    <div class="flex flex-col md:flex-row gap-6 items-start p-2 rounded-2xl">
                        <div class="w-full md:w-1/3 flex-shrink-0">
                            <img src="https://i.postimg.cc/ncdNcjxT/Noir-Jaune1-Photoroom.png" alt="Sterna Bénin" class="w-full h-auto rounded-xl">
                        </div>
                        <div class="w-full md:w-2/3">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">Au Bénin</h4>
                            <p class="text-md leading-relaxed text-gray-600 m-0">
                                Sterna Africa assure le lead du FESTISOL dans le département des collines. Nous avons regroupé les organisations de ce département dans un <strong>COLLECTIF FESTISOL COLLINES BÉNIN</strong> et avons pour tâche de présenter le festival, de former les organisations membres, et d'animer le festival.
                            </p>
                        </div>
                    </div>

                    <!-- Action Côte d'Ivoire -->
                    <div class="flex flex-col md:flex-row gap-6 items-start p-2 rounded-2xl">
                        <div class="w-full md:w-1/3 flex-shrink-0">
                            <img src="https://www.festivaldessolidarites.org/wp-content/themes/festisol/dist/logo.png" alt="Festisol CI" class="w-full h-auto rounded-xl">
                        </div>
                        <div class="w-full md:w-2/3">
                            <h4 class="text-xl font-bold text-gray-900 mb-2">En Côte d'Ivoire</h4>
                            <p class="text-md leading-relaxed text-gray-600 m-0">
                                Sterna Africa assure la coordination nationale du festival des solidarités sur toute l'étendue du territoire. Nous avons la responsabilité d’animer le réseau, de verser les soutiens financiers « coup de pouce », d'organiser des rencontres nationales, et de veiller au respect de la charte.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center">
                    <a href="/old/actualite/toutes_les_actualites.php" class="inline-flex items-center justify-center px-8 py-4 bg-sterna-blue text-white font-bold rounded-full hover:bg-sterna-yellow hover:text-gray-900 transition-colors duration-300 shadow-lg hover:shadow-xl group">
                        Découvrez nos activités <i class="fi fi-rr-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>
            </div>

        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>

</body>
</html>