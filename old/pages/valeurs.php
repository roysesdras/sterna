<?php include $_SERVER['DOCUMENT_ROOT'] . '/config/head.php'; ?>
<body class="bg-gray-100 font-sans text-gray-800">

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/nav.php'; ?>

    <header class="relative pt-32 pb-20 md:pt-40 md:pb-28 overflow-hidden bg-sterna-blue">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-gradient-to-b from-sterna-blue to-transparent opacity-90 z-10"></div>
        </div>
        <div class="container mx-auto px-6 relative z-20 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-sterna-yellow text-sterna-blue text-xs font-bold uppercase tracking-widest mb-4">Ce qui nous anime</span>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6">Nos <span class="text-pink-400">Valeurs</span></h1>
            <p class="text-lg md:text-xl text-blue-100 max-w-2xl mx-auto">Équité, respect et engagement communautaire.</p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-16 -mt-10 relative z-30 mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Colonne Texte -->
            <div class="lg:col-span-7 bg-white p-8 md:p-12 rounded-3xl shadow-xl">
                <h2 class="text-3xl font-black text-sterna-blue mb-6">Nos convictions</h2>
                <p class="text-lg leading-relaxed mb-6 font-medium text-gray-700">
                    Sterna Africa s'appuie sur des valeurs fortes pour mener à bien ses missions. Nous croyons que chaque individu a le droit de vivre dans la dignité, de se développer et de s'épanouir au sein de sa communauté. C'est pourquoi nous mettons tout en œuvre pour que nos actions reflètent nos convictions profondes.
                </p>
                <!-- Vous pouvez ajouter la suite de votre texte ici -->
                <p class="text-lg leading-relaxed mb-6 text-gray-600">
                    L'éthique et la responsabilité guident nos pas au quotidien. En travaillant avec nous, nos partenaires savent qu'ils s'associent à une démarche intègre, centrée sur l'humain et respectueuse de l'environnement. Continuez à écrire votre texte ici...
                </p>
                <p class="text-lg leading-relaxed mb-6 text-gray-600">
                    (Ce texte peut être aussi long que vous le souhaitez, les cartes à droite glisseront et resteront toujours visibles à l'écran grâce à l'effet "sticky" !)
                </p>
            </div>

            <!-- Colonne Cartes (Sticky) -->
            <div class="lg:col-span-5 relative">
                <div class="sticky top-24 grid grid-cols-1 sm:grid-cols-2 gap-4 lg:gap-6">
                    
                    <a href="#">
                        <div class="p-6 rounded-[35px] border border-gray-100 shadow-xl hover:shadow-2xl hover:shadow-pink-100 transition-all duration-500 group bg-white h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-pink-50 flex items-center justify-center text-sterna-blue text-2xl mb-4 group-hover:bg-sterna-blue group-hover:text-white transition-all">
                                <i class="fi fi-rr-heart"></i>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 uppercase mb-2">Solidarité</h3>
                            <p class="text-gray-500 text-xs leading-relaxed font-medium">L'entraide et le soutien mutuel au cœur de toutes nos actions.</p>
                        </div>
                    </a>

                    <a href="#">
                        <div class="p-6 rounded-[35px] border border-gray-100 shadow-xl hover:shadow-2xl hover:shadow-blue-100 transition-all duration-500 group bg-sterna-blue h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-sterna-yellow text-2xl mb-4 group-hover:bg-sterna-yellow group-hover:text-white transition-all">
                                <i class="fi fi-rr-eye"></i>
                            </div>
                            <h3 class="text-lg font-black text-white uppercase mb-2">Transparence</h3>
                            <p class="text-gray-100 text-xs leading-relaxed font-medium">Communiquer ouvertement sur la gestion de nos projets.</p>
                        </div>
                    </a>

                    <a href="#">
                        <div class="p-6 rounded-[35px] border border-gray-100 shadow-xl hover:shadow-2xl hover:shadow-orange-100 transition-all duration-500 group bg-sterna-yellow h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-white/30 flex items-center justify-center text-gray-900 text-2xl mb-4 group-hover:bg-sterna-blue group-hover:text-white transition-all">
                                <i class="fi fi-rr-hands-helping"></i>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 uppercase mb-2">Engagement</h3>
                            <p class="text-gray-700 text-xs leading-relaxed font-medium">Une détermination sans faille à agir pour le changement.</p>
                        </div>
                    </a>

                    <a href="#">
                        <div class="p-6 rounded-[35px] border border-gray-100 shadow-xl hover:shadow-2xl hover:shadow-teal-100 transition-all duration-500 group bg-white h-full flex flex-col items-center text-center">
                            <div class="w-14 h-14 rounded-2xl bg-teal-50 flex items-center justify-center text-teal-600 text-2xl mb-4 group-hover:bg-sterna-yellow group-hover:text-white transition-all">
                                <i class="fi fi-rr-scale"></i>
                            </div>
                            <h3 class="text-lg font-black text-gray-900 uppercase mb-2">Équité</h3>
                            <p class="text-gray-500 text-xs leading-relaxed font-medium">Offrir les mêmes chances de réussite à chacun.</p>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </main>

    <?php include $_SERVER['DOCUMENT_ROOT'] . '/config/footer_2.php'; ?>
</body>
</html>
