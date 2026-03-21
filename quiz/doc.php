 <!DOCTYPE html>
 <html lang="fr" class="dark">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

     <meta name="description" content="LiveQ : outil pédagogique universel conçu pour transformer l'apprentissage en une expérience interactive, inclusive et engageante. ">

     <title>Documentation</title>

     <script src="https://cdn.tailwindcss.com"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

     <!-- Favicons -->
     <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
     <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">

     <meta property="og:title" content="LiveQ" />
     <meta property="og:description" content="LiveQ : outil pédagogique universel conçu pour transformer l'apprentissage en une expérience interactive, inclusive et engageante." />
     <!-- <meta property="og:image" content="https://exemple.com/images/og-image.jpg" /> -->
     <meta property="og:url" content="https://sternaafrica.org/quiz" />
     <meta property="og:type" content="website" />

     <!-- Optionnel pour Facebook & co -->
     <meta property="og:site_name" content="LiveQ" />

     <!-- Optionnel pour Twitter (cartes) -->
     <meta name="twitter:card" content="summary_large_image" />
     <meta name="twitter:title" content="LiveQ" />
     <meta name="twitter:description" content="LiveQ : outil pédagogique universel conçu pour transformer l'apprentissage en une expérience interactive, inclusive et engageante." />
     <!-- <meta name="twitter:image" content="https://exemple.com/images/og-image.jpg" /> -->

     <script>
         tailwind.config = {
             darkMode: 'class',
             theme: {
                 extend: {
                     colors: {
                         dark: {
                             100: '#1a1a1a',
                             200: '#2d2d2d',
                             300: '#404040',
                             400: '#525252',
                         }
                     }
                 }
             }
         }
     </script>

     <style>
         .glass-effect {
             background: rgba(30, 30, 30, 0.7);
             backdrop-filter: blur(10px);
             border: 1px solid rgba(255, 255, 255, 0.1);
         }

         .gradient-border {
             background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
             padding: 2px;
             border-radius: 12px;
         }

         .gradient-text {
             background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
             -webkit-background-clip: text;
             -webkit-text-fill-color: transparent;
         }

         .faq-transition {
             transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
         }

         .floating {
             animation: floating 6s ease-in-out infinite;
         }

         @keyframes floating {

             0%,
             100% {
                 transform: translateY(0);
             }

             50% {
                 transform: translateY(-10px);
             }
         }

         .modal-overlay {
             background: rgba(0, 0, 0, 0.8);
             backdrop-filter: blur(5px);
         }

         .faq-answer {
             overflow: hidden;
             max-height: 0;
             transition: max-height 0.4s ease;
         }
     </style>

 </head>

 <body class="bg-dark-100 text-gray-200 min-h-screen font-sans">
     <!-- Hero Section -->
     <main class="bg-dark-900 py-12 mb-8">
         <div class="max-w-2xl mx-auto p-2 shadow-xl rounded-lg">
             <h1 class="text-4xl font-extrabold gradient-text mb-4 text-center">Documentation LiveQ</h1>
             <h3 class="text-2xl text-gray-300 mb-4">
                 Présentation
             </h3>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-4">
                 LiveQ est bien plus qu'une simple plateforme de quiz. C'est un outil pédagogique universel conçu pour transformer l'apprentissage en une expérience interactive, inclusive et engageante. Que ce soit pour l'éducation formelle, la sensibilisation, le renforcement de capacités ou la création de liens interculturels, LiveQ s'adapte à tous les contextes et toutes les ambitions éducatives.
             </p>

             <h3 class="text-2xl text-gray-300 mb-4">
                 Une vision éducative globale
             </h3>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-4">
                 LiveQ permet aux animateurs de créer des sessions de quiz dynamiques auxquelles les participants peuvent se connecter instantanément, que ce soit en présentiel ou à distance. Mais au-delà de la technologie, LiveQ porte une vision : rendre le savoir accessible à tous, partout, et créer des ponts entre les cultures.
             </p>

             <h3 class="text-2xl text-gray-300 mb-2">
                 Objectifs pédagogiques et sociaux
             </h3>
             <h5 class="text-xl text-gray-400 mb-4">
                 Apprendre et former de manière ludique
             </h5>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-4">
                 L’idée est de transformer les formations classiques en moments interactifs, de tester et renforcer les compétences de façon engageante, puis d’évaluer les acquis sur n’importe quelle thématique.
             </p>

             <h5 class="text-xl text-gray-400 mb-4">
                 Briser les barrières et les préjugés
             </h5>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-4">
                 Il s’agit de déconstruire les stéréotypes interculturels grâce à la connaissance, de réduire les inégalités d’accès à l’éducation en proposant une plateforme simple et accessible, et de favoriser l’interculturalité en créant des espaces d’apprentissage partagés.
             </p>

             <h5 class="text-xl text-gray-400 mb-4">
                 Créer du lien et de la solidarité
             </h5>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-4">
                 Connecter des participants venus de différents pays et cultures, d’animer des chantiers de solidarité internationale grâce à un outil fédérateur, et de construire des ponts entre les générations, les communautés et les territoires.
             </p>

             <h5 class="text-xl text-gray-400 mb-4">
                 Sensibiliser et transformer
             </h5>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-4">
                 L’enjeu est d’informer sur les grands enjeux mondiaux comme le climat, les droits humains ou le développement durable, d’éveiller les consciences autour de thématiques essentielles et d’inspirer l’action collective grâce à la connaissance partagée.
             </p>

             <h5 class="text-xl text-gray-400 mb-4">
                 Thématiques infinies
             </h5>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto mb-4">
                 LiveQ peut être utilisé pour explorer une multitude de sujets :
             <p class="text-lg text-gray-300">
                 Culture et géographie
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Découvrir les pays, leurs cultures, leurs traditions</li>
                     <li>Apprendre les langues, l'histoire, les patrimoines</li>
                     <li>Comprendre la diversité du monde</li>
                 </ul>
             </div>
             </p>

             <p class="text-lg text-gray-300">
                 Développement et solidarité internationale
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Objectifs de Développement Durable (ODD)</li>
                     <li>Coopération internationale et solidarité</li>
                     <li>Droits humains et justice sociale</li>
                 </ul>
             </div>
             </p>

             <p class="text-lg text-gray-300">
                 Environnement et sciences
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Changement climatique et biodiversité</li>
                     <li>Énergies renouvelables et économie circulaire</li>
                     <li>Sciences, innovations et technologies</li>
                 </ul>
             </div>
             </p>

             <p class="text-lg text-gray-300">
                 Numérique et société
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Culture numérique et citoyenneté digitale</li>
                     <li>Inclusion numérique et fracture digitale</li>
                     <li>Protection des données et cybersécurité</li>
                 </ul>
             </div>
             </p>

             <p class="text-lg text-gray-300">
                 Et bien d'autres encore...
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Santé et bien-être</li>
                     <li>Éducation financière</li>
                     <li>Entrepreneuriat social</li>
                     <li>Arts et créativité</li>
                     <li>Tout ce que vous pouvez imaginer !</li>
                 </ul>
             </div>
             </p>
             </p>

             <h3 class="text-2xl text-gray-300 mb-2">
                 Public cible : vraiment tous les publics
             </h3>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                 LiveQ a été conçu pour être universel et inclusif. Il s'adresse à :
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Enfants et jeunes : apprentissage ludique adapté à leur âge</li>
                     <li>Professionnels : formations continues, team building, sensibilisations</li>
                     <li>Associations et ONG : animation d'ateliers, événements de sensibilisation</li>
                     <li>Éducateurs et formateurs : outil pédagogique pour dynamiser leurs interventions</li>
                     <li>Communautés locales : événements participatifs et éducatifsactivités fédératrices entre volontaires de tous horizons</li>
                 </ul>
             </div>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                 Quel que soit l'âge, le niveau d'éducation, la langue ou le pays, LiveQ peut être adapté à chaque contexte.
             </p>
             </p>

             <h3 class="text-2xl text-gray-300 mb-2">
                 Un jeu à tout faire
             </h3>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                 LiveQ n'est pas un simple quiz. C'est un couteau suisse pédagogique qui peut être utilisé dans une infinité de situations :
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Renforcement de capacités après une formation</li>
                     <li>Évaluation ludique des connaissances acquises</li>
                     <li>Animation de soirées interculturelles sur des chantiers de solidarité</li>
                     <li>Sensibilisation lors d'événements publics ou festivals</li>
                     <li>Création de dialogue entre cultures différentes</li>
                     <li>Apprentissage collaboratif en classe ou en atelier</li>
                     <li>Challenge éducatif lors de compétitions amicales</li>
                 </ul>
             </div>

             <h3 class="text-2xl text-gray-300 mb-2">
                 L'impact de LiveQ
             </h3>
             <p class="text-lg text-gray-400 max-w-2xl mx-auto">
                 En utilisant LiveQ, vous contribuez à :
             <div class="p-4 text-gray-400">
                 <ul class="list-disc list-outside pl-6 text-lg">
                     <li>Démocratiser l'accès au savoir - Une connexion internet suffit, pas besoin d'équipement coûteux</li>
                     <li>Créer des ponts interculturels - Apprenez à connaître l'autre plutôt que de le juger</li>
                     <li>Rendre l'éducation attractive - Parce qu'apprendre peut et doit être un plaisir</li>
                     <li>Mesurer l'impact de vos formations et sensibilisations</li>
                     <li>Construire un monde plus inclusif où chacun a sa place</li>
                 </ul>
             </div>

             <section class="mb-6 border-b border-gray-700 pb-6">
                 <h3 class="text-2xl font-semibold text-gray-300 mb-4">Architecture de la plateforme</h3>
                 <p class="text-lg text-gray-400">
                     LiveQ fonctionne avec trois types d'acteurs distincts, chacun ayant son propre espace :
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg">
                         <li>Administrateur : Gère le contenu des questions et supervise la plateforme</li>
                         <li>Animateur : Lance les sessions de quiz et gère le déroulement du jeu</li>
                         <li>Participant : Répond aux questions en temps réel</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     URLs d'accès
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Participant : <a href="https://sternaafrica.org/quiz/participant" class="text-cyan-600" target="_blank">sternaafrica.org/quiz/participant</a></li>
                         <li>Animateur : <a href="https://sternaafrica.org/quiz/animateur" class="text-cyan-600" target="_blank">sternaafrica.org/quiz/animateur</a></li>
                         <li>Administrateur : Accès restreint (non publique)</li>
                     </ul>
                 </div>
                 </p>
             </section>

             <section class="mb-6 border-b border-gray-700 pb-6">
                 <h3 class="text-2xl font-semibold text-gray-300 mb-4">Guide de l'Animateur</h3>
                 <p class="text-lg text-gray-400">
                     Connexion :
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg">
                         <li>Accédez à <a href="https://sternaafrica.org/quiz/animateur"></a> sternaafrica.org/quiz/animateur</li>
                         <li>Entrez simplement votre pseudo (aucun mot de passe requis)</li>
                         <li>Un compte est automatiquement créé pour vous</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Création d'une session de quiz :
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Une fois connecté, générez un code d'animation unique</li>
                         <li>Ce code sera utilisé par vos participants pour rejoindre votre session</li>
                         <li>Partagez ce code avec vos participants via :
                             WhatsApp (créez un groupe pour coordonner);
                             Email;
                             Présentation orale (en présentiel);
                             Tout autre moyen de communication
                         </li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Déroulement de l'animation :
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Lancement des questions : Vous contrôlez le rythme du quiz en lançant les questions une par une</li>
                         <li>Suivi en temps réel : Les participants répondent dès qu'une question est lancée</li>
                         <li>Gestion du quiz : Vous décidez quand passer à la question suivante
                         </li>
                         <li>
                             Fin de session : Vous mettez fin au jeu quand vous le souhaitez
                         </li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Lorsque vous décidez de terminer le jeu :
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Cliquez sur le bouton de fin de session
                         </li>
                         <li>Tous les participants voient automatiquement leurs résultats finaux s'afficher sur leur écran</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Bonnes pratiques pour les animateurs
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Planification : Créez un groupe WhatsApp en amont pour informer vos participants de la date et de l'heure
                         </li>
                         <li>Communication : Partagez le code d'animation quelques minutes avant le début</li>
                         <li>
                             Présentiel ou distanciel : Le système fonctionne dans les deux contextes
                         </li>
                         <li>Sessions multiples : Vous pouvez organiser plusieurs sessions simultanées avec des codes différents</li>
                     </ul>
                 </div>
                 </p>

                 </p>
             </section>

             <section class="mb-6 border-b border-gray-700 pb-6">
                 <h3 class="text-2xl font-semibold text-gray-300 mb-4">Guide du Participant</h3>
                 <p class="text-lg text-gray-400">
                     Connexion
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg">
                         <li>Accédez à <a href="https://sternaafrica.org/quiz/participant" class="text-cyan-600" target="_blank">sternaafrica.org/quiz/participant</a></li>
                         <li>Entrez votre nom</li>
                         <li>Saisissez le code d'animation fourni par votre animateur</li>
                         <li>Cliquez sur "Rejoindre"</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Pendant le jeu
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Attente : Attendez que l'animateur lance la première question</li>
                         <li>Lisez attentivement la question</li>
                         <li>Cochez la ou les réponses qui vous semblent correctes</li>
                         <li>Validez votre réponse en cliquant sur le bouton de validation</li>
                         <li>Votre score s'affiche en temps réel au fur et à mesure du jeu</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Système de points
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>1 point par question correctement répondue</li>
                         <li>Le score est mis à jour instantanément après chaque validation</li>
                         <li>Vous pouvez suivre votre progression tout au long du jeu</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Lorsque l'animateur met fin à la session :
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Vos résultats finaux s'affichent automatiquement</li>
                         <li>Vous pouvez voir votre score total et votre performance</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Conseils pour les participants
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>Assurez-vous d'avoir une connexion internet stable</li>
                         <li>Notez bien le code d'animation fourni par votre animateur</li>
                         <li>Lisez attentivement chaque question avant de répondre</li>
                         <li>Certaines questions peuvent avoir plusieurs bonnes réponses</li>
                     </ul>
                 </div>
                 </p>
             </section>

             <section class="mb-6 pb-6">
                 <h3 class="text-2xl font-semibold text-gray-300 mb-4">En résumé</h3>
                 <p class="text-lg text-gray-400">
                     LiveQ rend l'apprentissage interactif, accessible et ludique. Que vous soyez animateur souhaitant dynamiser vos formations ou participant désireux d'apprendre en s'amusant, la plateforme offre une expérience simple et efficace.

                 </p>

                 <p class="text-lg text-gray-400">
                     Trois étapes simples :
                 <div class="p-4">
                     <ul class="list-disc list-outside pl-6 text-lg text-gray-400">
                         <li>L'animateur se connecte et génère un code</li>
                         <li>Les participants rejoignent avec ce code</li>
                         <li>Tout le monde apprend en jouant !</li>
                     </ul>
                 </div>
                 </p>

                 <p class="text-lg text-gray-400">
                     Bienvenue dans l'univers LiveQ, où l'éducation devient un jeu ! 🎉
                 </p>
             </section>

         </div>
     </main>

 </body>

 </html>