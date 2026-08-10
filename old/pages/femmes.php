<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <header class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <!-- Image de fond -->
            <img src="https://i.ibb.co/wFKwTLjj/1755593839077.jpg" alt="Enfants" class="w-full h-full object-cover opacity-60 mix-blend-luminosity">
            <!-- Surcouche bleue et dégradé -->
            <div class="absolute inset-0 bg-sterna-yellow/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-sterna-yellow via-sterna-yellow/80 to-transparent z-10"></div>
        </div>

        <div class="container mx-auto px-6 relative z-20 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-blue text-sterna-yellow text-xs font-bold uppercase tracking-widest mb-4">Notre Public Cible</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Les <span class="text-blue-950">Femmes</span></h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Autonomie socio-économique et défense des droits.</p>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 py-10 text-left text-gray-600 bg-gray-100 rounded-3xl shadow-xl -mt-10 relative z-30 mb-20">
        <div class="container mx-auto">
            <p class="text-lg leading-relaxed">Au cœur de nos actions sur le terrain, et plus particulièrement dans les zones rurales, l'accompagnement, la santé et l'émancipation des femmes occupent une place centrale.</p>

            <h2 class="text-3xl font-bold mb-6 text-gray-900">Autonomiser, informer et protéger les femmes au cœur des communautés</h2>

            <p class="text-lg leading-relaxed mb-4">
                Dans de nombreuses localités isolées, les femmes font face à des défis majeurs liés à l'accès à l'information, aux soins de base et à la valorisation de leurs rôles économiques et sociaux. C'est pourquoi nos programmes visent à leur offrir des espaces d'écoute, de formation et de solidarité pour qu'elles puissent prendre leur destin en main, préserver leur santé et celle de leurs familles.
            </p>

             <p class="text-lg leading-relaxed mb-4">
                Cet engagement au féminin se traduit par des initiatives fortes et ciblées :
            </p>

            <ul>
                <li class="mb-4">
                    <strong>La sensibilisation sur l'hygiène alimentaire et menstruelle :</strong> Parce que la santé passe par les gestes du quotidien, nous animons des ateliers pratiques sur l'hygiène de l'eau, la conservation des aliments et la propreté corporelle. Ces formations préviennent de nombreuses maladies et améliorent durablement la qualité de vie dans les foyers ruraux.
                </li>

                <li class="mb-4">
                    <strong>Les ateliers de premiers secours en milieu rural :</strong> Former les femmes aux gestes qui sauvent, c'est doter les communautés d'un bouclier de sécurité indispensable. En cas d'accident ou de malaise loin des centres de santé urbains, elles apprennent à réagir efficacement, devenant ainsi les premières actrices du soin et de la protection de leurs proches.
                </li>

                <li class="mb-4">
                    <strong>Le projet Sang Tabou :</strong> Un programme engagé dédié à la santé reproductive et menstruelle des femmes et des jeunes filles. En brisant les tabous ancrés dans les traditions, nous menons des actions de sensibilisation de proximité et distribuons des protections hygiéniques durables, permettant ainsi de lutter contre l'absentéisme scolaire et l'exclusion sociale liée aux règles.
                </li>
            </ul>

            <p class="text-lg leading-relaxed mb-4 mt-6 font-medium">
                Soutenir les femmes rurales, c'est leur redonner la place qu'elles méritent : celle de leaders, de gardiennes du savoir et de vecteurs de développement durable.
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
                        <img src="https://i.ibb.co/0y3Jp0nJ/1755593839061.jpg" alt="Action femmes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/0yG3GRf1/12.jpg" alt="Action femmes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    </div>
                    
                    <div class="min-w-[85%] sm:min-w-[60%] md:min-w-[45%] lg:min-w-[35%] shrink-0 snap-center rounded-3xl overflow-hidden shadow-lg h-64 md:h-80 relative group">
                        <img src="https://i.postimg.cc/FRfXVCzS/46.jpg" alt="Action femmes" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
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
