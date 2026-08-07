<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LiveQ</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Favicons -->
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="icon">
    <link href="https://sternaafrica.org/assets/img/icon-192.png" rel="apple-touch-icon">

    <script src="https://stats.digiroys.com/tracker.js" data-key="key_sterna_123"></script>

    <style>
        body {
            background-color: #0c0a09;
        }

        .choice-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .choice-card:active {
            transform: scale(0.96);
        }
    </style>
</head>

<body class="text-white min-h-screen flex flex-col items-center justify-center p-6">

    <div class="text-center mb-10">
        <h1 class="text-5xl font-black italic tracking-tighter bg-gradient-to-r from-purple-400 to-blue-500 bg-clip-text text-transparent">
            LiveQ
        </h1>
        <p class="text-gray-500 uppercase tracking-[0.2em] text-[10px] mt-2 font-bold">Plateforme de Jeu Live</p>
    </div>

    <div class="w-full max-w-sm space-y-4">
        <a href="participant" class="choice-card block p-5 rounded-3xl flex items-center gap-5 hover:border-blue-500/50">
            <div class="w-14 h-14 bg-blue-600/20 rounded-2xl flex items-center justify-center border border-blue-500/30 text-blue-400">
                <i class="fas fa-play text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold leading-none">Rejoindre</h2>
                <p class="text-gray-500 text-xs mt-1">Je suis un participant</p>
            </div>
        </a>

        <a href="animateur" class="choice-card block p-5 rounded-3xl flex items-center gap-5 border-purple-500/30 bg-purple-500/5 hover:border-purple-500/60">
            <div class="w-14 h-14 bg-purple-600/20 rounded-2xl flex items-center justify-center border border-purple-500/30 text-purple-400">
                <i class="fas fa-microphone-alt text-xl"></i>
            </div>
            <div>
                <h2 class="text-lg font-bold leading-none">Animer</h2>
                <p class="text-gray-500 text-xs mt-1">Gérer la session de quiz</p>
            </div>
        </a>
    </div>

    <button id="install-dash-btn" class="hidden fixed bottom-8 bg-amber-500 text-black px-8 py-3 rounded-full font-black shadow-2xl animate-bounce flex items-center gap-2">
        <i class="fas fa-download"></i> INSTALLER L'APPLICATION
    </button>

    <script>
        // Le code que tu m'as montré, intégré ici :
        let dashPrompt;
        const dashBtn = document.getElementById('install-dash-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            dashPrompt = e;
            // On affiche le bouton d'installation sur cette page d'accueil
            if (dashBtn) dashBtn.classList.remove('hidden');
        });

        if (dashBtn) {
            dashBtn.addEventListener('click', async () => {
                if (dashPrompt) {
                    dashPrompt.prompt();
                    const {
                        outcome
                    } = await dashPrompt.userChoice;
                    if (outcome === 'accepted') {
                        dashBtn.classList.add('hidden');
                    }
                    dashPrompt = null;
                }
            });
        }
    </script>
</body>

</html>